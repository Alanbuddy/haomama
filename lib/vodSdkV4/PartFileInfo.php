<?php

//文件分片信息
class PartFileInfo {
	public $_offset;
	public $_dataSize;
	public $_isSent;
	public $_retryTimes;
	public function __construct($offset, $dataSize, $isSent, $retryTimes) {
		$this->_offset = $offset;
		$this->_dataSize = $dataSize;
		$this->_isSent = $isSent;
		$this->_retryTimes = $retryTimes;
	}
}
