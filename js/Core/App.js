/* globals get, introJs */
import { storage } from "./../utilities.js";
import CompChart from "./CompChart.js";
import Dialog from "./Dialog.js";
import Table from "./Table.js";

let App = {
  Table: true,
  CompChart: storage.get("CompChart") || false,
  ValuesComparisment: storage.get("ValuesComparisment") || false,
  introJS: false,
  online: navigator.onLine,
  timezone: "GMT+0200",
  //Controller
  check_GET: {
    options: get.options,
    before() {
      $.each(this.options, function(key, value) {
        switch (key) {
          case "platform":
            if (["xb1", "ps4", "pc"].indexOf(value) !== -1) {
              const val = value.toUpperCase() + ":";
              Table.orders = val;
            }
            break;
          case "ratio":
            const index = ["min", "max", "avg", "median", "mode"].indexOf(value);
            if (index !== -1) {
              Table.ratioCalcFrom = value;
            }
            break;
          case "type":
            if (["sell", "buy"].indexOf(value) !== -1) {
              Table.dataType = value;
            }
            break;
          case "values":
            if (value === "global") {
              Table.statValue = false;
            } else if (value === "platform") {
              Table.statValue = true;
            }
            break;
        }
      });
    },
    after() {
      $.each(this.options, function(key, value) {
        switch (key) {
          case "search":
            $("#search").val(value);
            $("#search").trigger("input");
            break;
          case "sort":
            const sorting = value.split(",");

            if (sorting.length > 2) {
              return;
            }

            Table.$elem.order([sorting]).draw();
            break;
          case "cols":
            const colArray = value.split(",");

            //Shows indexed columns
            $.each(Table.$elem.columns().visible(), function(a, b) {
              if (a === 0) {
                return;
              }
              if (colArray.indexOf(a.toString()) !== -1) {
                Table.$elem.column(a).visible(true);
              } else {
                Table.$elem.column(a).visible(false);
              }
            });

            break;
        }
      });
    }
  },
  connection: {
    handleOnline() {
      App.online = true;
      $("body").removeClass("offline");
    },
    handleOffline() {
      App.online = false;
      $("body").addClass("offline");
    },
    checkStatus() {
      return App.online;
    },
    init() {
      function updateOnlineStatus(event) {
        if (navigator.onLine) {
          App.connection.handleOnline();
        } else {
          App.connection.handleOffline();
        }
      }
      window.addEventListener("online", updateOnlineStatus);
      window.addEventListener("offline", updateOnlineStatus);
    }
  },
  listners: {
    shareBTN() {
      $("#share").click(function() {
        //basic
        let options = {
          platform: Table.orders.replace(":", "").toLowerCase(),
          type: Table.dataType,
          ratio: Table.ratioCalcFrom
        };
        //order
        const order = Table.$elem.order()[0];
        if (typeof(order) !== "undefined") {
          options.order = order.join(",");
        }
        //search
        const searchQuery = $("#search").val();
        if (searchQuery.length > 0) {
          options.search = searchQuery;
        }
        //cols
        const colsVisibility = [];
        $.each(Table.$elem.columns().visible(), function(a, b) {
          if (a === 0) {
            return;
          }
          if (b) {
            colsVisibility.push(a);
          }
        });
        options.cols = colsVisibility.join(",");
        //values
        if (Table.statValue) {
          options.values = "global";
        } else {
          options.values = "platform";
        }

        let url = window.location.origin + window.location.pathname + "?";

        $.each(options, function(key, value) {
          if (typeof(value) !== "undefined") {
            url = url + key + "=" + value + "&";
          };
        });
        url = url.substr(0, url.length - 1);

        $(".share-copy-area").val(url);
        $(".share-copy-area").select();
        try {
          document.execCommand("copy");

          $(this).addClass("success");
          const that = this;
          setTimeout(function() {
            $(that).removeClass("success");
          }, 500);
        } catch (e) {
          alert("Unable to copy");
        }

      });
    },
    dialogs() {
      //FAQ
      const faq = new Dialog("faq", "faq-help-open").setBasicListners();
      faq.setCloseButton(".dialog-close");

      //Builder
      let relic = false;
      const builder = new Dialog("relic-run", "build-relic-run").setBasicListners();

      $.getJSON("json/worldState/relicByRelic.json").then(function(relics) {
        let string = [];
        $.each(relics, function(a, b) {

          string.push(`<div class="type-${a}">`);
          $.each(b, function(c, relic) {
            string.push(`<label class="relic-type-label">
            <input type="checkbox" class="relic-type" name="type" value="${relic}" hidden><div class="type">${relic}</div>
            </label>`);
          });
          string.push("</div>");
        });
        $("#relic-run .types").html(string.join(""));
      });

      $(".relics-label input").click(function() {
        const show = $(this).val();
        relic = $(this);
        if (!$(".types .type-" + show).is(":visible")) {
          $("[class^='type-']").hide();
          $(".types .type-" + show).show();
        }
      });

      builder.setCloseButton(".dialog-close", function() {
        if (relic) {
          let types = [];
          $.each($(".relic-type:checked"), function(a, b) {
            $(b).prop("checked", false);
            types.push($(b).val());
          });

          relic.prop("checked", false);
          $("[class^='type-']").hide();

          const searchFor = relic.val() + ":" + " " + types.join(" ");

          $("#search").val(searchFor);
          $("#search").trigger("input");
        }
      });
    },
    detailsHideOnClick() {
      let hide = function(e, detailsClass) {
        if ($(".introjs-helperLayer").length !== 0) {
          return;
        }
        const $elem = $(detailsClass);
        const $details = $(e.target).closest(detailsClass);

        if ($details.length === 0) {
          if ($elem.prop("open")) {
            $elem.prop("open", false);
          }
        }
      };
      $(document).click(function(e) {
        hide(e, ".details-drop");
        hide(e, ".filters-details");
      });
    },
    introJS() {
      $("#introJS").click(function() {
        let init = function(clear = false) {
          const $dialog = document.getElementById("faq");
          const $filters = $(".filters-details");
          const $loading = $(".details-drop");
          //clear the old attributes
          if (clear) {
            const clear9 = $("[data-step=\"9\"]");
            const clear10 = $("[data-step=\"10\"]");
            clear9.removeAttr("data-step");
            clear9.removeAttr("data-intro");
            clear10.removeAttr("data-step");
            clear10.removeAttr("data-intro");
          }

          const $favExample = $(".favourite-btn:visible").first(); //10
          //Sort by item so we can target a element
          Table.$elem.order([0, "asc"]).draw();
          const $sumPartExample = $("table small.save:visible").first(); //9
          $("body").css("overflow-y", "inherit");
          $dialog.close();
          //set part 9
          $sumPartExample.attr("data-step", 9);
          $sumPartExample.attr("data-intro", `This 'short' shows you how much can you <span class='success-save'>save</span>
          by buying or <span class='fail-save'>lose</span>
          by selling (red background) Parts/Set, the P = parts, the S = set.`);
          //set part 10
          $favExample.attr("data-step", 10);
          $favExample.attr("data-intro", "You can add single items to favourite list to quick access them by a button.");

          setTimeout(function() {
            introJs().setOption("showBullets", false).onchange(function(elem) {
              const step = $(elem).data("step");
              switch (step) {
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                  if (!$filters.prop("open")) {
                    $filters.prop("open", true);
                  }
                  break;
                case 7:
                  if ($filters.prop("open")) {
                    $filters.prop("open", false);
                  }
                  break;
                case 9:
                  if (Table.$elem.order()[0][0] !== 0) {
                    Table.$elem.order([0, "asc"]).draw();
                  }
                  break;
                case 13:
                case 14:
                case 15:
                  if (!$loading.prop("open")) {
                    $loading.prop("open", true);
                  }
                  break;
                case 16:
                  if ($loading.prop("open")) {
                    $loading.prop("open", false);
                  }
                  break;
              }
            }).start();
          }, 400);
        };
        if (App.introJS) {
          init(true);
        } else {
          $.ajax({
            url: "js/intro.min.js",
            cache: true,
            dataType: "script"
          }).done(function() {
            $("head").append($("<link rel='stylesheet' href='css/introjs.min.css' type='text/css'>"));
            App.introJS = true;
            init();
          });
        }
      });
    }
  },
  init() {
    App.connection.init();

    window.onbeforeprint = function() {
      document.location.href = `nojs/${Table.dataType}pc.html`;
    };

    if (App.CompChart) {
      $("#CompChart").attr("checked", true);
      CompChart.init();
    }
    if (App.ValuesComparisment) {
      $("#ValuesComparisment").attr("checked", true);
      $(".values-comparisment").toggle();
    }
    if (Table.compareWithChat) {
      $("#ChatData").attr("checked", true);
    }

    App.listners.dialogs();
    App.listners.detailsHideOnClick();
    App.listners.introJS();
    App.check_GET.before();
    Table.init(function() {
      Table.listners.init();
      App.check_GET.after();
      App.listners.shareBTN();
      if (!App.online) {
        App.connection.handleOffline();
      }
    });
  }
};
export default App;