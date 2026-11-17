(function () {
  "use strict";

  function notify(message) {
    var toast = document.getElementById("toast");
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add("visible");
    clearTimeout(notify.timeout);
    notify.timeout = setTimeout(function () { toast.classList.remove("visible"); }, 4200);
  }

  /* Mobile menu, tour/blog filters */
  document.addEventListener("click", function (event) {
    var toggle = event.target.closest(".nav-toggle");
    if (toggle) {
      var nav = document.querySelector(".navlinks");
      var open = nav.classList.toggle("open");
      toggle.setAttribute("aria-expanded", String(open));
    }
    var filter = event.target.closest(".filter");
    if (filter) {
      var group = filter.closest("[data-filter-group]");
      group.querySelectorAll(".filter").forEach(function (button) { button.classList.toggle("active", button === filter); });
      var kind = group.dataset.filterGroup;
      var key = kind === "tour" ? "type" : "category";
      document.querySelectorAll(kind === "tour" ? ".tour-card" : ".blog-card").forEach(function (card) {
        card.hidden = filter.dataset.filter !== "All" && card.dataset[key] !== filter.dataset.filter;
      });
    }
  });

  /* GPX upload check on the Suggest a Ride form */
  document.addEventListener("change", function (event) {
    if (!event.target.matches(".upload input")) return;
    var file = event.target.files[0];
    var label = event.target.closest(".upload").querySelector("span");
    if (file && (!file.name.toLowerCase().endsWith(".gpx") || file.size > 5 * 1024 * 1024)) {
      event.target.value = "";
      notify("Please choose a GPX file smaller than 5MB.");
    } else if (file) {
      label.innerHTML = "✓<br>" + file.name.replace(/[<>&"]/g, "") + "<br><small>Ready to submit</small>";
    }
  });

  /* Booking calendar: picks a preferred date (today or later) for the request email */
  var root = document.getElementById("calendar");
  var monthLabel = document.querySelector(".calendar-month");
  var selectedLabel = document.getElementById("selected-date");
  var hidden = document.getElementById("preferred-date");
  if (root && monthLabel) {
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    var cursor = new Date(today.getFullYear(), today.getMonth(), 1);
    var renderMonth = function () {
      monthLabel.textContent = cursor.toLocaleDateString("en-US", { month: "long", year: "numeric" });
      var first = new Date(cursor.getFullYear(), cursor.getMonth(), 1).getDay();
      var count = new Date(cursor.getFullYear(), cursor.getMonth() + 1, 0).getDate();
      var html = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"].map(function (d) { return '<span class="weekday">' + d + "</span>"; }).join("");
      for (var i = 0; i < first; i++) html += "<span></span>";
      for (var day = 1; day <= count; day++) {
        var past = new Date(cursor.getFullYear(), cursor.getMonth(), day) < today;
        html += '<button type="button" data-day="' + day + '"' + (past ? " disabled" : "") + ">" + day + "</button>";
      }
      root.innerHTML = html;
      document.querySelector('[data-calendar="-1"]').disabled = cursor <= new Date(today.getFullYear(), today.getMonth(), 1);
    };
    renderMonth();
    document.querySelectorAll("[data-calendar]").forEach(function (button) {
      button.addEventListener("click", function () {
        cursor.setMonth(cursor.getMonth() + Number(button.dataset.calendar));
        renderMonth();
      });
    });
    root.addEventListener("click", function (event) {
      var button = event.target.closest("[data-day]");
      if (!button || button.disabled) return;
      root.querySelectorAll(".selected").forEach(function (el) { el.classList.remove("selected"); });
      button.classList.add("selected");
      var picked = new Date(cursor.getFullYear(), cursor.getMonth(), Number(button.dataset.day));
      var text = picked.toLocaleDateString("en-US", { weekday: "short", month: "short", day: "numeric", year: "numeric" });
      selectedLabel.textContent = "Preferred date: " + text;
      if (hidden) hidden.value = text;
    });
  }
})();
