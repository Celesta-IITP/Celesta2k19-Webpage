const regEvFunc = async (eventId, celestaId, accessToken) => {
  let spinner = document.querySelector(".spinner");
  spinner.style.display = "inline-block";
  let formData = new FormData();
  formData.append("eventid", eventId);
  formData.append("celestaid", celestaId);
  formData.append("access_token", accessToken);
  let url="https://celesta.org.in/backend/admin/functions/reg_team_event.php";
  // let url="http://localhost/celesta2k19-webpage/backend/admin/functions/reg_team_event.php";
  let res = await fetch(
    url,
    {
      body: formData,
      method: "post"
    }
  );
  res = await res.json();
  console.log(res);
  spinner.style.display = "none";

  let htmlData = "";
  if (res.status === 302) {
    res.message.forEach(mes => {
      htmlData += `
          <div class="toast fade show" style="z-index: 999">
              <div class="toast-header bg-warning">
                  <strong class="mr-auto"><i class="fa fa-globe"></i> Warning</strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
              </div>
              <div class="toast-body">${mes}</div>
          </div>
          `;
    });
  }
  else if (res.status === 202) {
    res.message.forEach(mes => {
      htmlData += `
          <div class="toast fade show" style="z-index: 999">
              <div class="toast-header bg-success">
                  <strong class="mr-auto"><i class="fa fa-globe"></i> Success</strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
              </div>
              <div class="toast-body">${mes}</div>
          </div>
          `;
    });
  }
  else if (res.status === 401) {
    res.message.forEach(mes => {
      htmlData += `
          <div class="toast fade show" style="z-index: 999">
              <div class="toast-header bg-danger">
                  <strong class="mr-auto"><i class="fa fa-globe"></i> Warning</strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
              </div>
              <div class="toast-body">${mes}</div>
          </div>
          `;
    });
  }
  else if (res.status === 404) {
    res.message.forEach(mes => {
      htmlData += `
          <div class="toast fade show" style="z-index: 999">
              <div class="toast-header bg-danger">
                  <strong class="mr-auto"><i class="fa fa-globe"></i> Error</strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
              </div>
              <div class="toast-body">${mes}</div>
          </div>
          `;
    });
  }
  var toastContainer = document.querySelector(".toastContainer");
  toastContainer.innerHTML = htmlData;
  $(".toast").toast();
};
