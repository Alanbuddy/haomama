
$ ->
  editor = (id)->
    E = window.wangEditor
    editor = new E(id)
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

  editor("#edit-area")

  E = window.wangEditor
  editor1 = new E("#edit-title")
  # 图片上传地址
  editor1.customConfig.uploadImgServer = '/upload' 
  editor1.customConfig.showLinkImg = false
  editor1.customConfig.menus = [
        'head'
     ]
  editor1.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  }
  editor1.create()