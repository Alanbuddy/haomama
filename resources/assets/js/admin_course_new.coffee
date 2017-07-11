
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

  E = window.wangEditor
  editor = new E('#title-area')
  # 图片上传地址
  editor.customConfig.uploadImgServer = '/upload' 
  editor.customConfig.showLinkImg = false
  editor.customConfig.menus = [
        'head'
     ]
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  }
  editor.create()


 
 


  