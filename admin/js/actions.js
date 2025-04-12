$(".verify_user_btn").click(function () {
  var user_id_v = $(this).data("user-id");
  console.log("User ID:", user_id_v);
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "php/admin_ajax.php?verify_user",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).text("Verified");
      } else {
        $(button).attr("disabled", false);
        alert("something is wrong,try again after some time");
      }
    },
  });
});

$(".block_user_btn").click(function () {
  var user_id_v = $(this).data("user-id");
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "php/admin_ajax.php?block_user",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).hide();
        $(button).siblings(".unblock_user_btn").show();
        $(button).siblings(".unblock_user_btn").attr("disabled", false);
      } else {
        $(button).attr("disabled", false);
        alert("something is wrong,try again after some time");
      }
    },
  });
});

$(".unblock_user_btn").click(function () {
  var user_id_v = $(this).data("user-id");
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "php/admin_ajax.php?unblock_user",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).hide();
        $(button).siblings(".block_user_btn").show();
        $(button).siblings(".block_user_btn").attr("disabled", false);
      } else {
        $(button).attr("disabled", false);
        alert("something is wrong,try again after some time");
      }
    },
  });
});

// for searching the user
$("#search").keyup(function () {
  var keyword_v = $(this).val().trim();

  $.ajax({
    url: "php/admin_ajax.php?search",
    method: "post",
    dataType: "json",
    data: { keyword: keyword_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $("table tbody").html(response.users);

      } else {
        $("table tbody").html('<tr><td colspan="3" class="text-center text-muted">No User Found!</td></tr>');
      }
    },
  });
});

{/* <label for="exampleDataList" class="form-label">Datalist example</label>
<input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
<datalist id="datalistOptions">
  <option value="San Francisco">
  <option value="New York">
  <option value="Seattle">
  <option value="Los Angeles">
  <option value="Chicago">
</datalist> */}

{/* <div class="row">
  <div class="col">
    <input type="text" class="form-control" placeholder="First name" aria-label="First name">
  </div>
  <div class="col">
    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
  </div>
</div> */}

{/* <div class="col-md-4">
<label for="inputState" class="form-label">State</label>
<select id="inputState" class="form-select">
  <option selected>Choose...</option>
  <option>...</option>
</select>
</div> */}

{/* <select class="form-select" aria-label="Default select example">
  <option selected>Open this select menu</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select> */}

{/* <div class="card">
  <div class="card-header">
    Featured
  </div>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div> */}

{/* <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table> */}
