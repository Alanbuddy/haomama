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

    $("#teacher-name").val($("#name-span"))
    $("#mobile").val($("#mobile-span"))
    $("#tencent").val($("#tencent-span"))
    $("#mail").val($("#mail-span"))
    $("#title").val($("#title-span"))
    $("#tel").val($("#tel-span"))
    $("#major").val($("#major-span"))
    $("#remark").val($("#remark-span"))
    $("#reward").val($("#reward-span"))
    $("#book").val($("#book-span"))
    $("#base").val($("#base-span"))
    desc = $("#desc-span").text()
    editor.txt.html(desc)

  $("#finish-btn").click ->
    name = $("#teacher-name").val().trim
    mobile = $("#mobile").val().trim
    tencent = $("#tencent").val().trim
    mail = $("#mail").val().trim
    title = $("#title").val().trim
    tel = $("#tel").val().trim
    major = $("#major").val().trim
    remark = $("#remark").val().trim
    reward = $("#reward").val().trim
    book = $("#book").val().trim
    base = $("#base").val().trim
    desc = editor.txt.html() 






