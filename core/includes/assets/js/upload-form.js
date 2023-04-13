function FileInputHandler(event) {
  var Files = document.getElementById("FileInput").files;
  console.log("files", Files);
  for (var i = 0; i < Files.length; i++) {
    var File = Files[i];
    jQuery("table#FileInputDetails tbody").append(
      `
      <tr>
  		<td>
        <div>
          <span>${File.name}</span>
          <div class="row-actions">
            <span><a href="">Edit</a></span>
            <span><a href="">Delete</a></span>
          </div>
        </div>
        <div class="hide">
          <input type="text"class="duration" name="file_name[]" value="${File.name}"/>
          <p>
          <small><input class="button" type="button" name="cancel" value="Cancel"/></small>
          <small><input class="button" type="button" name="save" value="Save"/></small>
          </p>
        </div>

      </td>
  		<td>
        <p>${File.size}</p>
        <div class="hide">
          <input type="number"class="duration" name="file_size[]" value="${File.size}"/>
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

jQuery(".duration").on("keyup", function () {
  console.log(jQuery(this).value);
});
