$ ->
  $(document).scroll ->
    if $(document).scrollTop() > 100
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('body').animate({scrollTop: 0})


	$("#another-baby").click ->
    baby_dom = document.createElement("div")
    $(baby_dom).addClass("add-baby-div").html($(".add-baby-div").html()).css('display', 'flex')
    $(baby_dom).insertBefore("#another-baby")

  $(document).on 'click', '.close-add-item', ->
    $(this).closest('.add-baby-div').hide()

  change_avatar = (gender, birthday, object) ->
    today = new Date()
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/kid_male.png')
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/baby_male.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/kid_female.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/baby_female.png')

  $(document).on 'change', '.birthday', ->
    birthday = $(this).val()
    birthday = new Date(birthday)
    gender = $(this).closest('.row-div').siblings('.row-div').find('.gender').val()
    change_avatar(gender, birthday, this)

  $(document).on 'change', '.gender', ->
    gender = $(this).val()
    birthday = $(this).closest('.row-div').siblings('.row-div').find('.birthday').val()
    birthday = new Date(birthday)
    change_avatar(gender, birthday, this)

  $('.favorite').click ->
    fav = $(this).attr('data-fav')
    $.postJSON(
      '/',
      {
        favorite: fav
      },
      (data) ->
        console.log(data)
        if data.success
          if fav == 'true'
            $('.favorite').attr('src', '/icon/like_selected.png')
            $('.favorite').attr('data-fav', 'false')
            showMsg('成功收藏该课程', 'center')
          else
            $('.favorite').attr('src', '/icon/like_normal.png')
            $('.favorite').attr('data-fav', 'true')
            showMsg('收藏已取消', 'center')
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  $('.admire-icon').click ->
    ad = $(this).attr('data-ad')
    $.postJSON(
      '/',
      {
        admire: ad
      },
      (data) ->
        console.log(data)
        if data.success
          if ad == 'true'
            $('.admire-icon').attr('src', '/icon/like1_selected.png')
            $('.admire-icon').attr('data-ad', 'false')
            showMsg('点赞完成', 'center')
          else
            $('.admire-icon').attr('src', '/icon/like1_normal.png')
            $('.admire-icon').attr('data-ad', 'true')
            showMsg('取消点赞', 'center')
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  $('.view-more').click ->
    $(this).hide()
    unfold_height = $(this).siblings('.fold-div').find('.unview-div').height()
    $(this).siblings('.fold-div').slideDown(
      $(this).siblings('.fold-div').animate({height: unfold_height + 15})
      )

  $('.teacher-view-more').click ->
    $(this).hide()
    unfold_height = $(this).siblings('.teacher-fold-div').find('.teacher-unview-div').height()
    $(this).siblings('.teacher-fold-div').slideDown(
      $(this).siblings('.teacher-fold-div').animate({height: unfold_height + 15})
      )

