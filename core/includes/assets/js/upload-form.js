function bytesToSize(bytes) {
  var sizes = ["B", "K", "M", "G", "T", "P"];
  for (var i = 0; i < sizes.length; i++) {
    if (bytes <= 1024) {
      return bytes + " " + sizes[i];
    } else {
      bytes = parseFloat(bytes / 1024).toFixed(2);
    }
  }
  return bytes + " P";
}

function FileInputHandler(event) {
  var Files = document.getElementById("FileInput").files;
  console.log("files", Files);
  for (var i = 0; i < Files.length; i++) {
    var File = Files[i];
    var file_name = File.name;
    console.log("file_name", file_name.split(".").shift());
    console.log("ext", file_name.split(".").pop());
    jQuery("table#FileInputDetails tbody").append(
      `
      <tr>
      <td>
          <input type="text"class="duration" name="file_name[]" value="${file_name}"/>
      </td> 
      <td>
        <span>${bytesToSize(File.size)}</span>
        <div class="hide">
          <input type="number"class="duration" name="file_size[]" value="${
            File.size
          }"/>
        </div>
      </td>
      <td class="Upload_Duration">
          <input type="number" min="0" max="999" class="duration" name="Duration_hr[]" placeholder="Hour"/>
          <input type="number" min="0" max="59" class="duration" name="Duration_min[]" placeholder="Minutes"/>
          <input type="number" min="0" max="59"  class="duration" name="Duration_sec[]" placeholder="Seconds"/>
      </td>
      </tr> 
      `
    );
    jQuery("#FileInputDetails").removeClass("hide");
    jQuery("#FileInput").addClass("hide");
  }
}
jQuery(document).ready(function () {
  jQuery(".duration").on("keyup", function () {
    console.log(jQuery(this).value);
  });
  jQuery("a#delete").map((index, param) => {
    jQuery(param).on("click", function (e) {
      e.preventDefault();
      var fd = new FormData();
      fd.append("action", "delete_transcribe");
      fd.append("id", jQuery(this).data("id"));
      jQuery.ajax({
        type: "POST",
        dataType: "html",
        url: myAjax.ajaxurl,
        data: fd,
        contentType: false,
        processData: false,
        success: function (id) {
          const tr = jQuery("tr#" + id);
          tr.animate({ opacity: "0" }, 150, function () {
            tr.animate({ height: "0px" }, 150, function () {
              tr.remove();
            });
          });
        },
      });
    });
  });
});
