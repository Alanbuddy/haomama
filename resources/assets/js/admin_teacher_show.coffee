$ ->
  E = window.wangEditor
  editor = new E('#edit-area')
  # 图片上传地址
  editor.customConfig.uploadImgServer = '/upload' 
  editor.customConfig.showLinkImg = false
  editor.customConfig.menus = [
        'head',
        'image'
     ]
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  }
  editor.create()


  $("#edit-btn").click ->
    $(this).toggle()
    $("#finish-btn").toggle()
    $(".unedit-box").toggle()
    $(".edit-box").toggle()
    $("#second-row").removeClass("mt30")
    $(".text-message").removeClass("mt15")
    $("#reward-label").removeClass("vt")
    $("#book-label").removeClass("vt")
