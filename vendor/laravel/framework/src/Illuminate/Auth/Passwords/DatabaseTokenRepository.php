<?php

namespace Illuminate\Auth\Passwords;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Str;

class DatabaseTokenRepository implements TokenRepositoryInterface
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The Hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The token database table column for identifying unique user.
     * @var
     */
    protected $column;

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface $connection
     * @param  \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param  string $table
     * @param  string $hashKey
     * @param  int $expires
     * @param string $column
     */
    public function __construct(ConnectionInterface $connection, HasherContract $hasher,
                                $table, $hashKey, $expires = 60, $column = 'email')
    {
        $this->table = $table;
        $this->hasher = $hasher;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;

        $this->column = $column;
    }

    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param null $token
     * @return string
     */
    public function create(CanResetPasswordContract $user, $token = null)
    {
//        $email = $user->getEmailForPasswordReset();
        $email = $user->getWayToContactForPasswordReset($this->column);

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
//        $token = $this->createNewToken();
        $token = $token ?: $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $column
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user)
    {
        return $this->getTable()->where('email', $user->getWayToContactForPasswordReset($this->column))->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string $email
     * @param  string $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
//        dd(2,$this->hasher->make($token));
        return ['email' => $email, 'token' => $this->hasher->make($token), 'created_at' => new Carbon];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $token
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token)
    {
        $record = (array)$this->getTable()->where(
//            'email', $user->getEmailForPasswordReset()
            'email', $user->getWayToContactForPasswordReset($this->column)
        )->first();

        return $record &&
            !$this->tokenExpired($record['created_at']) &&
            $this->hasher->check($token, $record['token']);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  string $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    /**
     * Delete a token record by user.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @return void
     */
    public function delete(CanResetPasswordContract $user)
    {
        $this->deleteExisting($user);
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the hasher instance.
     *
     * @return \Illuminate\Contracts\Hashing\Hasher
     */
    public function getHasher()
    {
        return $this->hasher;
    }
}