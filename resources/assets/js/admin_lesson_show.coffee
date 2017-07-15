$ ->
  # 视频课时用代码
  # E = window.wangEditor
  # editor = new E('#edit-box')
  # # 图片上传地址
  # editor.customConfig.uploadImgServer = '/upload' 
  # editor.customConfig.showLinkImg = false
  # editor.customConfig.menus = [
  #       'head',
  #       'image'
  #    ]
  # editor.customConfig.uploadHeaders = {
  #   'Accept' : 'HTML'
  # }
  # editor.create()

  # $("#edit-btn").click ->
  #   $(this).toggle()
  #   $("#finish-btn").toggle()
  #   $(".unedit-box").toggle()
  #   $(".edit-box").toggle()

  # 
  # 音频课时用
  E = window.wangEditor
  editor = new E('#edit-box')
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
