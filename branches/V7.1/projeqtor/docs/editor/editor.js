var screenHeight=$(window).height(); 
$( document ).ready(function() {
  $("#editor").height($(window).height()-$("#buttonDiv").height()-$(".title").height()-30);
  //$("#preview").width($("#errorDiv").width());
});
$("#editor").on("change", convertEditor);

function selectFile(file) {
  $("#file").val(file);
  $.ajax({
    url: "controller.php",
    data: {
      action: "getFile",
      file: file
    },
    success: function( result ) {
      $("#editor").val(result);
      convertEditor();
    }
  });
  
}
function convertEditor() {
  $("#action").val("convert");
  $.ajax({
    type: "POST",
    url: "controller.php",
    data: $("#editorForm").serialize(), 
    success: function(result){
      var errors="";
      posErr=result.indexOf('/!\\');
      while (posErr>=0) {
        posEnd=result.indexOf('<br/>')+5;
        errors+=result.substring(posErr+4,posEnd);
        result=result.substr(posEnd);
        posErr=result.indexOf('/!\\');
      }
      if (errors) {
        $("#errorDiv").html(errors);
        $("#errorDiv").height(150);
      } else {
        $("#errorDiv").html("");
        $("#errorDiv").height(0);
      }
      $("#preview").html(result);
    }
  });
}

function saveFile() {
  $("#action").val("save");
  $.ajax({
    type: "POST",
    url: "controller.php",
    data: $("#editorForm").serialize(), 
    success: function(result){
      $("#resultMsg").html(result);
      setTimeout('$("#resultMsg").html("");',2000);
    }
  });
}
function undoFile() {
  if (!$("#file").val()) {
    $("#editor").val("");
    convertEditor();
  } else {
    selectFile($("#file").val());
  }
}