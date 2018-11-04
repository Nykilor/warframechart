import { storage, capitalize, isValidRegex, jQueryMobile, platformFix, createYMDDate, deleteZeros, findMode } from "./../utilities.js";
import CompChart from "./CompChart.js";
import ValuesComparisment from "./ValuesComparisment.js";
import ChatData from "./ChatData.js";
import MarketData from "./MarketData.js";
import App from "./App.js";

jQueryMobile();

//TODO GOT TO MAKE A KEY FOR A COPY OF ACCCTUALY USSSED DATA TO BE able to calc some stuff
let Table = {
  //The DataTable elem
  "$elem": null,
  //The platform
  orders: storage.get("orders") || "PC:",
  //Display either the values for certain platform or get min,max,avg,median,mode from all 3 (xbox, pc, ps4)
  statValue: storage.get("statValue") || false,
  //Fav list
  favourite: storage.get("favourite") || [],
  //Show values for buyers or sellers
  dataType: storage.get("dataTypes") || "sell",
  //Show the comparisment with chat
  compareWithChat: storage.get("compareWithChat") || false,
  //What column form should be the PLAT:DUCAT ratio calculated
  baseCalcFrom: storage.get("ratioCalc") || "min",
  onlinePlayerTime: {},
  ignoredPlayers: storage.get("ignored-players") || [],
  ignoredPlayersCalcOnClose: false,
  sourceData: {
    buy: null,
    sell: null
  },
  renders: {
    //returns a button with the count of sellers for platform
    sellers(data, type, row) {
      if (type === "display") {
        let orderCount = 0;

        $.each(data, function(a) {
          if (a.indexOf(Table.orders) !== -1) {
            orderCount++;
          }
        });
        const name = row.name;
        const theGroup = name.split(" ")[0];
        const star = (Table.favourite.indexOf(name) !== -1) ? "icon-star-filled" : "icon-star";
        const groupLike = (Table.favourite.indexOf(theGroup) !== -1) ? " group-like" : "";
        const $buttonOrders = "<button class='sellers-btn icon-basket'>" + orderCount + "</button>";
        const $buttonFav = "<button class='favourite-btn " + star + groupLike + "' data-group=" + theGroup + "></button>";

        return $buttonOrders + $buttonFav;
      } else {
        let string = "";
        $.each(data, function(a) {
          if (a.indexOf(Table.orders) !== -1) {
            string = string + a.substr(a.indexOf(":") + 1) + ", ";
          }
        });
        return string;
      }

    },
    onlineTime(data) {
      //Map all the things for redability and ease of understanding
      let object = {
        0: {
          string: "Sun",
          periods: {
          }
        },
        1: {
          string: "Mon",
          periods: {
          }
        },
        2: {
          string: "Tue",
          periods: {
          }
        },
        3: {
          string: "Wed",
          periods: {
          }
        },
        4: {
          string: "Thu",
          periods: {
          }
        },
        5: {
          string: "Fri",
          periods: {
          }
        },
        6: {
          string: "Sat",
          periods: {
          }
        }
      };

      $.each(data[0].source, function(key, sourceDay) {
          const date = new Date(sourceDay.date + " " + App.timezone);
          const dayOfWeek = date.getDay();
          const period = date.getHours();

          object[dayOfWeek].periods[period] = 1;
      });

      let string = "";

      $.each(object, function(day, data) {
        let addition = `<div class="flex flex-row">
        <div class="online-block">
          <span>${data.string}</span>
          <div class="hours-blocks">`;
        for (let i = 0; i <= 23; i++) {
          const isActive = (typeof(data.periods[i]) !== "undefined") ? "active" : "";
          addition = addition + `<div class="hour-block ${isActive}">${i}</div>`;
        }
        string = string + addition + "</div></div></div>";
      });

      return string;
    },
    //adds a row to show a table with listed sellers
    sellersList(data) {
      const orders = data.orders;
      let tbody = "";
      $.each(orders, function(a, b) {
        if (a.indexOf(Table.orders) !== -1) {
          const playerName = a.replace(Table.orders, "");
          const platform = Table.orders.slice(0, -1);
          const onlineTimeContent = (typeof(Table.onlinePlayerTime[a]) !== "undefined") ? ["icon-calendar", Table.onlinePlayerTime[a]] : ["icon-calendar-empty", ""];
          const isIgnoredPlayer = (Table.ignoredPlayers.indexOf(a) !== -1) ? ["icon-eye", "ignored-player-listing"] : ["icon-eye-off", ""];

          if (typeof(b) === "number") {
            tbody = tbody + `<tr class="${isIgnoredPlayer[1]}">
              <td><button type="button" class="${isIgnoredPlayer[0]} ignore-player-button" data-player="${a}"></button></td>
              <td><button type="button" class="${onlineTimeContent[0]} check-online-time-button" data-player="${playerName}" data-platform="${platform}"></button></td>
              <td><a href="https://warframe.market/profile/${playerName}" target="_blank">${playerName}</a></td>
              <td>${b}</td>
            </tr>`;
          } else {
            tbody = tbody + `<tr class="${isIgnoredPlayer[1]}">
              <td><button type="button" class="${isIgnoredPlayer[0]} ignore-player-button" data-player="${a}"></button></td>
              <td><button type="button" class="${onlineTimeContent[0]} check-online-time-button" data-player="${playerName}" data-platform="${platform}"></button></td>
              <td><a href="https://warframe.market/profile/${playerName}" target="_blank">${playerName}</a></td>
              <td>${b[0]} - <small> R ${b[1]}</small></td>
            </tr>`;
          }

          tbody = tbody + `<tr class="player-online-hours online-time-overflow" data-valueof="${a}" style="display: none;">
          <td colspan="3">
            <div class="flex flex-column">
            ${onlineTimeContent[1]}
            </div>
          </td>
          </tr>`;
        }
      });

      const table = `<table class="inner-list-table">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>PLAYER</th>
            <th>PRICE</th>
          </tr>
        </thead>
        <tbody>
          ${tbody}
        </tbody>
      </table>`;
      return table;
    },
    //returns modified row for chat values to be displayed
    chatValuesDisplay(values, type, key) {
      if (type === "display" && Table.compareWithChat) {
        const chatKey = "chat_" + key;
        const chatValue = (typeof(values[chatKey]) !== "undefined") ? values[chatKey] : "?";
        const comparisment = values[key] + "<br>" + chatValue;
        return comparisment;
      } else {
        return values[key];
      }
    },
    //returns a html string for item groups that shows if parts or set is better deal
    groupNameEndRender(rows, group) {
      const items = rows.data();
      //look for item with "Set" in it because it holds the information about the id's related to it
      let partAmount;
      let sot;
      for (let i = 0; i < items.length; i++) {
        if (items[i].name.indexOf("Set") !== -1) {
          partAmount = items[i].set_parts.length + 1;
          sot = items[i].market_pv_diff;
        }
      }

      if (items.length === partAmount) {
        let msg = "";
        if (sot > 0) {
          if (Table.dataType === "sell") {
            msg = `<button class='save success-save btn-order-by icon-desktop' data-order="10,desc">${sot} P</button>`;
          } else {
            msg = `<button class='save fail-save btn-order-by icon-desktop' data-order="10,desc">${sot} S</button>`;
          }
        } else if (sot < 0) {
          if (Table.dataType === "sell") {
            msg = `<button class='save success-save btn-order-by icon-desktop' data-order="10,desc">${sot} S</button>`;
          } else {
            msg = `<button class='save fail-save btn-order-by icon-desktop' data-order="10,desc">${sot} P</button>`;
          }
        }

        const star = (Table.favourite.indexOf(group) !== -1) ? "group-like" : "";
        return msg + `<button class="favourite-btn-all icon-star ${star}" data-group="${group}">${group} +</button>`;
      }
    },
    //returns the plat:ducat ratio of signle items
    ratio(data, type, row) {
      let ratio = 0;

      if (typeof(row.ducat) !== "undefined") {
        ratio = Math.floor((row.ducat / row[Table.baseCalcFrom]) * 10) / 10;
      }

      ratio = (!isFinite(ratio)) ? 0 : ratio;

      return ratio;
    },
    vaulted(data, type, row) {
      if (row.vaulted) {
        data = "is_vaulted";
      } else {
        data = "not_vaulted";
      }

      return data;
    },
    drop(data, type, row) {
      if (type === "display" && data !== "none") {
        const dataArray = data.split(",");
        let newString = "<div class='drop-location'>";
        $.each(dataArray, function(key, value) {
          const capitalized = capitalize(value);
          newString = newString + `<button type="button" class="search-for-button" data-search="${capitalized}">${capitalized}</button>`;
        });
        data = newString + "</div>";
      } else if (type === "display" && data === "none") {
        data = "";
      }
      return data;
    },
    partsSumColumn(data, type, row, meta) {
      let marketSum = "";
      let dataSet = Table.sourceData[Table.dataType];
      if (type === "display") {
        if (row.name.indexOf("Set") !== -1) {
          const parts = row.set_parts;
          const sumParts = function(objectKey) {
            let sum = 0;
            if (row[objectKey] === 0) {
              return null;
            }
            for (let i = 0; i < parts.length; i++) {
              const id = parts[i];
              if (dataSet[id - 1][objectKey] === 0) {
                sum = null;
                break;
              }
              if (dataSet[id - 1].double_part) {
                sum += dataSet[id - 1][objectKey] * 2;
              } else {
                sum += dataSet[id - 1][objectKey];
              }
            }
            return sum;
          };

          let objectKeyMarket = Table.baseCalcFrom;
          marketSum = sumParts(objectKeyMarket);

          let calculation;
          if (marketSum !== null) {
            if (row[objectKeyMarket] < marketSum) {
              if (Table.dataType === "sell") {
                calculation = marketSum - row[objectKeyMarket];
                marketSum = `S ${calculation}`;
              } else {
                calculation = row[objectKeyMarket] - marketSum;
                marketSum = `S ${calculation}`;
              }
            } else if (row[objectKeyMarket] > marketSum) {
              if (Table.dataType === "sell") {
                calculation = row[objectKeyMarket] - marketSum;
                marketSum = `P ${calculation}`;
              } else {
                calculation = marketSum - row[objectKeyMarket];
                marketSum = `P ${calculation}`;
              }
            } else {
              calculation = 0;
              marketSum = "";
            }
          } else {
            calculation = "";
          }

          for (let i = 0; i < parts.length; i++) {
            const id = parts[i];
            dataSet[id - 1].market_pv_diff = calculation;
          }

          row.market_pv_diff = calculation;
          const nameParts = row.name.split(" ");
          let group = (typeof(nameParts[1]) !== "undefined") ? nameParts[0] + " " + nameParts[1] : nameParts[0];
          marketSum = `<button type="button" class="search-for-button" data-search="${group}">${marketSum}</button>`;
        }
      } else {
        if (typeof(row.market_pv_diff) !== "undefined" || row.name.indexOf("Set") !== -1) {
          marketSum = row.market_pv_diff;
        } else {
          marketSum = "";
        }
      }

      return marketSum;

    }
  },
  //All event listners
  listners: {
    init() {
      let l = Table.listners;
      l.showOrders();
      l.favourite();
      l.search();
      l.statValue();
      l.platform();
      l.dataType();
      l.column();
      l.baseCalc();
      //l.order();
      l.compareWithChatRow();
      l.searchForButton();
      l.ignorePlayerButton();
      l.orderByButton();
      l.onlinePlayerTime();

      //Chart
      l.showChart();
      l.loadGraphData();
      l.dialogChart();

      //ValuesComparisment
      l.showValuesComparisment();

      if (jQuery.browser.mobile) {
        //mobile-version
      } else {
        //desktop-version
        l.pageChange();
      }

    },
    //ValuesComparisment and Graph because of reasons.
    loadGraphData() {

      $("#dataTable tbody").on("click", "tr[role='row'] td.name-col", function() {
        //Only if the user wants to fetch
        if (!App.CompChart) {
          if (!App.ValuesComparisment) {
              return;
          }
        }

        //If is offline
        if (!App.connection.checkStatus()) {
          return;
        }

        let $loading = $(".loading-indicator");
        $loading.addClass("show");

        const $row = $(this).parent();
        let item = Table.$elem.row($row).data();

        const platform = platformFix(Table.orders);

        if (typeof(CompChart.loadedData.cache[item.id]) === "undefined") {
          //Get the data and then
          CompChart.getChartData(item.id, platform, function(dataSet) {
            //Set basic cache
            CompChart.loadedData.cache.set(item.id);
            //Engage the extensions
            if (App.ValuesComparisment) {
              ValuesComparisment.init(dataSet, item);
            }
              //Cache the set
              //If the set does not have the key empty.
              if (typeof(dataSet.empty) === "undefined") {
                CompChart.loadedData.cache[item.id][Table.dataType][platform].data = dataSet;
                CompChart.loadedData.cache[item.id][Table.dataType][platform].daysLoaded = CompChart.chart.daysBack;
              }

            if (App.CompChart) {
              CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item);
            }
          });
        } else {
          if (!CompChart.loadedData.cache[item.id][Table.dataType][platform].data) {
            CompChart.getChartData(item.id, platform, function(dataSet) {
              if (App.ValuesComparisment) {
                ValuesComparisment.init(dataSet, item);
              }
              //If the set does not have the key empty.
              if (typeof(dataSet.empty) === "undefined") {
                CompChart.loadedData.cache[item.id][Table.dataType][platform].data = dataSet;
                CompChart.loadedData.cache[item.id][Table.dataType][platform].daysLoaded = CompChart.chart.daysBack;
              }
              if (App.CompChart) {
                CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item, true);
              }
            });
          } else {
            if (CompChart.loadedData.cache[item.id][Table.dataType][platform].daysLoaded >= CompChart.chart.daysBack) {
              let dataSet = CompChart.loadedData.cache[item.id][Table.dataType][platform].data;

              if (App.ValuesComparisment) {
                ValuesComparisment.init(dataSet, item);
              }
              if (App.CompChart) {
                CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item);
              }
            } else {
              //todo This is the spot if there is any data in cache and the called amout of data lacks few days (i.e. 90 loaded 99 requested) (load 9 more, join it with the cache array and draw)
              const diffrence = CompChart.chart.daysBack - CompChart.loadedData.cache[item.id][Table.dataType][platform].daysLoaded;
              let start = createYMDDate(-CompChart.chart.daysBack);
              //end got to be the start from last fetch
              let end = createYMDDate(-(CompChart.chart.daysBack - diffrence));
              //Call the getData to fetch the diffrence, join it and show it to the audience
              CompChart.getChartData(item.id, platform, function(dataSet) {
                //If the set does not have the key empty.
                let cachedData = CompChart.loadedData.cache[item.id][Table.dataType][platform].data;
                if (typeof(dataSet.empty) === "undefined") {
                  cachedData = (!cachedData) ? {} : cachedData;
                  $.each(dataSet, function(key, value) {
                    if (cachedData[key]) {
                      cachedData[key] = [...value, ...cachedData[key]];
                    } else {
                      cachedData[key] = value;
                    }
                  });
                  CompChart.loadedData.cache[item.id][Table.dataType][platform].data = cachedData;
                }
                CompChart.loadedData.cache[item.id][Table.dataType][platform].daysLoaded = CompChart.chart.daysBack;
                dataSet = cachedData;

                let filtered = CompChart.chart.getFilteredSet(dataSet);
                if (App.ValuesComparisment) {
                  ValuesComparisment.init(filtered, item);
                }
                CompChart.chart.init(filtered, item, true);
              }, start, end);
            }
          }
        }
        setTimeout(function() {
          $loading.removeClass("show");
        }, 600);
      });
    },
    showOrders() {
      let showSellers = function(elem) {
        const clickedElem = elem;

        let table = Table.$elem;
        let tr = $(clickedElem).closest("tr");
        let row = table.row(tr);

        if (row.child.isShown()) {
          // This row is "shown" open - close it
          row.child.hide();
          tr.removeClass("shown");
          if (Table.ignoredPlayersCalcOnClose) {
            Table.ignoredPlayersCalcOnClose = false;
            Table.repopulate();
          }
        } else {
          // Open this row
          row.child(Table.renders.sellersList(row.data())).show();
          tr.addClass("shown");
        }
      };

      $("#dataTable tbody").on("click", ".sellers-btn", function() {
        showSellers(this);
      });
    },
    favourite() {
      $("#dataTable tbody").on("click", ".favourite-btn", function() {
        let tr = $(this).closest("tr");
        let row = Table.$elem.row(tr);

        const name = row.data().name;
        const favIndex = Table.favourite.indexOf(name);

        if (favIndex !== -1) {
          $(this).removeClass("icon-star-filled").addClass("icon-star");
          Table.favourite.splice(favIndex, 1);
        } else {
          $(this).addClass("icon-star-filled").removeClass("icon-star");
          Table.favourite.push(name);
        }

        storage.set("favourite", Table.favourite);

      });

      $("#dataTable tbody").on("click", ".favourite-btn-all", function() {
        const favWhat = $(this).data("group");
        const favIndex = Table.favourite.indexOf(favWhat);
        const groupElems = $("[data-group='" + favWhat + "']");

        if (favIndex !== -1) {
          for (let i = 0; i < groupElems.length; i++) {
            $(groupElems[i]).removeClass("group-like");
          }
          Table.favourite.splice(favIndex, 1);
        } else {
          for (let i = 0; i < groupElems.length; i++) {
            $(groupElems[i]).addClass("group-like");
          }
          Table.favourite.push(favWhat);
        }
        storage.set("favourite", Table.favourite);
      });
    },
    search() {
      const $search = $("#search");
      const $searchFav = $("#show-fav");
      let clonePrefixSearch = function(val) {
        //"lith: v1 v2 v3" to "lith v1|lith v2|lith v3"
        const valArray = val.split(" ");
        const startWith = valArray[0].replace(":", "");
        valArray.splice(0, 1);
        val = startWith + " " + valArray.join("|" + startWith + " ");

        if (isValidRegex(val)) {
          Table.$elem.search(val, true, false).draw();
        }
      };
      let searchByColumns = function(val) {
        //The avaliable columns to search by, they must be in the same order as the initated columns in Tables Object
        const columnsSearchBy = ["item", "min", "max", "avg", "median", "mode", "ducat", "ratio", "player", "drop", "type"];
        const searchIfColumnExists = function(string) {
        const equalSignPlace = string.indexOf("=");
          if (equalSignPlace !== -1) {
              const column = string.substring(0, equalSignPlace).toLocaleLowerCase();
              const searchFor = string.substr(equalSignPlace + 1);
              const columnIndex = columnsSearchBy.indexOf(column);

              if (columnIndex !== -1) {
                Table.$elem.column(columnIndex).search(searchFor);
              }
          }
        };
        if (val.indexOf("|") !== -1) {
          const val = val.split("|");
        }

        if (typeof(val) === "object") {
          val.forEach(function(valuePart) {
            const equalSignPlace = valuePart.indexOf("=");
            if (equalSignPlace !== -1) {
              searchIfColumnExists(valuePart);
            }
          });
        } else {
          searchIfColumnExists(val);
        }

        Table.$elem.draw();
      };
      //last val
      const lastSearch = (Table.$elem.state().search.search.length > 0) ? Table.$elem.state().search.search : storage.get("search-box");
      $search.val(lastSearch);

      let timeout = false;
      $search.on("input", function() {
        const val = this.value;
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          storage.set("search-box", val);
          //Resets the possible column searching
          Table.$elem.search("").columns().search("");
          if (val.indexOf(":") !== -1) {
            clonePrefixSearch(val);
          } else if (val.indexOf("=") !== -1) {
            searchByColumns(val);
          } else {
            if (isValidRegex(val)) {
              Table.$elem.search(val, true, false).draw();
            }
          }
        }, 500);
      });

      $("body").keypress(function() {
        if (!$search.is(":focus")) {
          $search.focus();
        }
      });

      $searchFav.click(function() {
        const value = Table.favourite.join("|");
        //If the search is for it stop
        if ($search.val() === value) {
         return;
        }

        $search.val(value);
        Table.$elem.search(value, true, false).draw();
      });
    },
    column() {
      //sets default state
      $.each(Table.$elem.state().columns, function(a, b) {
        if (b.visible && a > 0 && a < 11) {
          $(".show-column[value=" + a + "]").attr("checked", true);
        }
      });
      //handles event
      $(".show-column").click(function() {
        const column = Table.$elem.column($(this).val());
        const order = Table.$elem.order();
        column.visible(!column.visible());

        if (typeof(order[0]) !== "undefined" && order[0][0] === 0) {
          Table.$elem.draw();
        }
      });
    },
    baseCalc() {
      $(`.ratio-calc[value="${Table.baseCalcFrom}"]`).attr("checked", true);

      $(".ratio-calc").click(function() {
        const calcFrom = $(this).val();
        if (calcFrom !== Table.baseCalcFrom) {
          storage.set("ratioCalc", calcFrom);
          Table.baseCalcFrom = calcFrom;
          Table.repopulate();
        }

      });
    },
    statValue() {
      if (Table.statValue) {
        $("#order-based input").attr("checked", true);
      }
      $(".value-type").click(function() {
        const value = parseInt($(this).val(), 10);

        if (Table.statValue === value) {
          return;
        }

        Table.statValue = value;
        storage.set("statValue", Table.statValue);
        Table.repopulate();
      });
    },
    platform() {
      if (Table.orders !== "PC:") {
        $(`input[value="${Table.orders}"]`).attr("checked", true);
      }
      $(".platform").click(function() {
        if ($(this).val !== Table.orders) {
          Table.orders = $(this).val();
          storage.set("orders", Table.orders);
          Table.repopulate();
        }
      });
    },
    dataType() {
      if (Table.dataType === "buy") {
        $("input[value=buy]").attr("checked", true);
      }
      $(".data-type").click(function() {
        if ($(this).val() !== Table.dataType) {
          Table.dataType = $(this).val();
          storage.set("dataTypes", Table.dataType);
          Table.repopulate();
        }
      });
    },
    dialogChart() {
      const $dialog = document.getElementById("chart-dialog");

      $("#dataTable tbody").on("click", "tr[role='row'] td.name-col", function() {
        //Only if the user wants to fetch
        if (!App.CompChart) {
          if (!App.ValuesComparisment) {
            return;
          }
        }

        //If is offline
        if (!App.connection.checkStatus()) {
          return;
        }
        $("#chart-title").text($(this).text());
        $("body").css("overflow-y", "hidden");
        $dialog.showModal();
        $("#chart-dialog").scrollTop(0);
      });

      $(document).on("click", "dialog[open]", function(e) {
        if ($(e.target).is("dialog")) {
          $("body").css("overflow-y", "inherit");
          $dialog.close();
        }
      });
    },
    order() {
      Table.$elem.on("order.dt", function() {
        const order = Table.$elem.order();
        let enabled = false;
        for (let i = 0; i < order.length; i++) {
          if (order[i][0] === 0) {
            enabled = true;
            break;
          } else {
            enabled = false;
          }
        }
        if (enabled) {
          Table.$elem.rowGroup().enable();
        } else {
          Table.$elem.rowGroup().disable();
        }
      });
    },
    compareWithChatRow() {
      $("#ChatData").change(function() {
        Table.compareWithChat = !Table.compareWithChat;
        storage.set("compareWithChat", Table.compareWithChat);
        Table.repopulate();
      });
    },
    showChart() {
      $("#CompChart").change(function() {
        App.CompChart = !App.CompChart;
        storage.set("CompChart", App.CompChart);
        if (typeof(Chart) === "undefined") {
          CompChart.init();
        } else {
          $(".chart").toggle();
        }
      });
    },
    showValuesComparisment() {
      $("#ValuesComparisment").change(function() {
        App.ValuesComparisment = !App.ValuesComparisment;
        storage.set("ValuesComparisment", App.ValuesComparisment);
        $(".values-comparisment").toggle();
      });
    },
    pageChange() {
      $(document).on("keydown", function(e) {
        if (!$("input").is(":focus") && !$("dialog").is("[open]")) {
          if (e.keyCode === 39) {
            Table.$elem.page("next").draw("page");
          } else if (e.keyCode === 37) {
            Table.$elem.page("previous").draw("page");
          }
        }
      });
    },
    searchForButton() {
      $(document).on("click", ".search-for-button", function(e) {
        const searchFor = $(this).data("search");
        const $elem = $("#search");
        let triggerSearch = false;

        if (!e.ctrlKey) {
          triggerSearch = true;
          $elem.val(searchFor);
        } else {
          $elem.val(function(index, value) {
            //Trigger only if needed
            if (value.indexOf(searchFor) === -1) {
              triggerSearch = true;
              if (value.length > 0) {
                return value + "|" + searchFor;
              } else {
                return searchFor;
              }
            } else {
              return value;
            }
          });
        }

        if (triggerSearch) {
          $("#search").trigger("input");
        }
      });
    },
    orderByButton() {
      $(document).on("click", ".btn-order-by", function() {
        const $elem = $(this);
        const data = $elem.data("order");
        let order = data.split(",");
        order[0] = parseInt(order[0]);

        Table.$elem.order(order).draw();
      });
    },
    ignorePlayerButton() {
      $(document).on("click", ".ignore-player-button", function() {
        const $elem = $(this);
        const $tr = $elem.parent().parent();
        const data = $elem.data("player");
        let list = Table.ignoredPlayers;
        let index = list.indexOf(data);

        $tr.toggleClass("ignored-player-listing");
        if (index !== -1) {
          $elem.removeClass("icon-eye").addClass("icon-eye-off");
          list.splice(index, 1);
        } else {
          $elem.removeClass("icon-eye-off").addClass("icon-eye");
          list.push(data);
        }

        Table.ignoredPlayersCalcOnClose = true;
        storage.set("ignored-players", list);
      });
    },
    onlinePlayerTime() {
      $(document).on("click", ".check-online-time-button", function() {
        const $that = $(this);
        const platform = $that.data("platform");
        const player = $that.data("player");
        const valueof = platform + ":" + player;
        const $elem = $that.parents("tr").first().next();
        //If fetched and generated once it will only show/hide the additional row
        if ($that.hasClass("icon-calendar")) {
          if ($elem.is(":visible")) {
            $elem.hide();
          } else {
            $elem.show();
          }

          return;
        }


        $that.prop("disabled", true);
        $that.removeClass("icon-calendar-empty").addClass("icon-spin6");
        $.getJSON(`api/data/player/${platform}/"${player}`, function(result, textStatus, xhr) {
          const status = xhr.status;
          if (status === 204) {
            $that.removeClass("icon-spin6").addClass("icon-calendar-times-o text-not-success");
            setTimeout(function() {
              $that.removeClass("icon-calendar-times-o text-not-success").addClass("icon-calendar-empty");
            }, 500);
          } else {
            const string = Table.renders.onlineTime(result.response);
            Table.onlinePlayerTime[valueof] = string;

            $elem.show();
            $elem.find(".flex-column").html(string);
            $that.removeClass("icon-spin6").addClass("icon-calendar-check-o text-success");
            setTimeout(function() {
              $that.prop("disabled", false);
              $that.removeClass("icon-calendar-check-o text-success").addClass("icon-calendar");
            }, 500);
          }
        }).fail(function(reason) {
          console.log(reason);
        });
      });
    }
  },
  dataPrep: {
    //array, int, array
    chatValue(dataSet, i, chatData) {
      const item = dataSet[i];
      let itemChat = false;

      for (let i = 0; i < chatData.length; i++) {
        if (chatData[i].name === item.name) {
          itemChat = chatData[i];
          break;
        }
      }
      item.chat_min = itemChat.min;
      item.chat_max = itemChat.max;
      item.chat_avg = itemChat.avg;
      item.chat_median = itemChat.median;
    },
    calculateStatsFromOrders(orders, ignoreThoseKeys) {
      let min, max, avg, median, mode;
      let ordersCopy = JSON.parse(JSON.stringify(orders));
      let platform = Table.orders;
      //Deletes the ignored keys for future calculations
      ignoreThoseKeys.forEach(function(key) {
        delete ordersCopy[key];
      });
      //Removes the not needed keys
      $.each(ordersCopy, function(key) {
        if (!(key.substring(0, 3) === platform)) {
          delete ordersCopy[key];
        }
      });
      //creates values array (it's always sorted so no need to do that again)
      let ordersCopyValues = Object.values(ordersCopy);

      if (ordersCopyValues.length > 0) {
        let ordersCopyValuesSum = ordersCopyValues.reduce((a, b) => a + b, 0);
        //self explainatory
        min = Math.min(...ordersCopyValues);
        max = Math.max(...ordersCopyValues);
        avg = Math.floor(ordersCopyValuesSum / ordersCopyValues.length);
        let halfLengthKey = Math.floor((ordersCopyValues.length / 2) - 1);
        median = (ordersCopyValues.length % 2) ? (ordersCopyValues[halfLengthKey] + ordersCopyValues[halfLengthKey + 1]) / 2 : ordersCopyValues[halfLengthKey];
        median = Math.floor(median);
        mode = parseInt(findMode(ordersCopyValues));
      } else {
        min = 0;
        max = 0;
        avg = 0;
        median = 0;
        mode = 0;
      }

      return { min, max, avg, median, mode };
    },
    marketValue(dataSet) {
      //creates copy to not change the given object
      let market = JSON.parse(JSON.stringify(dataSet));
      const platform = platformFix(Table.orders);
      $.each(market, function(a, b) {
        if (Table.statValue) {
          let ignore = [];
          let newValues;
          //check if the players from ignored list got anything listed for this item
          Table.ignoredPlayers.forEach(function(player) {
            if (b.orders.hasOwnProperty(player)) {
              ignore.push(player);
            }
          });

          if (ignore.length > 0) {
            newValues = Table.dataPrep.calculateStatsFromOrders(b.orders, ignore);
            //The spread operator for b = { ...b, ...newValues } didn't seem to be working
            b.min = newValues.min;
            b.max = newValues.max;
            b.avg = newValues.avg;
            b.median = newValues.median;
            b.mode = newValues.mode;
          } else {
            b.min = b.min[platform];
            b.max = b.max[platform];
            b.avg = b.avg[platform];
            b.median = b.median[platform];
            b.mode = b.mode[platform];
          }
        } else {
          const minVal = deleteZeros(Object.values(b.min));
          const maxVal = deleteZeros(Object.values(b.max));
          const avgVal = deleteZeros(Object.values(b.avg));
          const medianVal = deleteZeros(Object.values(b.median));
          const mode = deleteZeros(Object.values(b.mode));

          b.min = (minVal.length > 0) ? Math.min(...minVal) : 0;
          b.max = (maxVal.length > 0) ? Math.max(...maxVal) : 0;

          if (avgVal.length > 1) {
            const sum = avgVal.reduce(function(a, b) {
              return a + b;
            });
            const avg = sum / avgVal.length;
            b.avg = Math.floor(avg);
          } else {
            b.avg = (typeof(avgVal[0]) !== "undefined") ? avgVal[0] : 0;
          }

          //mode
          if (mode.length > 0) {
            const modeSum = mode.reduce(function(a, b) {
              return a + b;
            });

            b.mode = Math.floor(modeSum / mode.length);
          } else {
            b.mode = 0;
          }


          //Profesional programing right here gentelmen
          medianVal.sort();
          switch (medianVal.length) {
            case 3:
              b.median = medianVal[1];
              break;
            case 2:
              b.median = (medianVal[0] + medianVal[1]) / 2;
              break;
            case 1:
              b.median = medianVal[0];
              break;
            case 0:
              b.median = 0;
              break;
          }
        }
      });

      return market;
    },
    getRequestedData() {
      return new Promise(function(resolve) {
        return MarketData.getBase(Table.dataType).then(function(result, status, object) {
          //Update the last update timer in the top left
          const lastUpdate = new Date(object.getResponseHeader("Last-Modified")).getTime();
          const timeNow = new Date();
          const now = Math.floor((timeNow.getTime() - lastUpdate) / 60000);
          const $elem = $("#last-update");
          $elem.html("<span id='lastUpdate'>" + now + "</span> minutes ago.");

          if (Table.compareWithChat) {
            ChatData.getBase(Table.dataType).then(function(chat) {
              //returns {"market": array, "chat": array}
              resolve({
                "market": result,
                "chat": chat
              });
            });
          } else {
            //returns array
            resolve({
              "market": result
            });
          }
        });
      });
    },
    prepareRequestedData(resolver, callback = false) {
        const chat = (typeof(resolver.chat) !== "undefined") ? resolver.chat : false;
        let market = Table.dataPrep.marketValue(resolver.market);
        //var passed to DataTable object
        let dataSet;
        //Set the variable
        if (Table.compareWithChat) {
          for (let i = 0; i < market.length; i++) {
            if (chat) {
              Table.dataPrep.chatValue(market, i, chat);
            }
          }
        }

        dataSet = market;

        if (callback) {
          callback(dataSet);
        } else {
          return dataSet;
        }
    }
  },
  //Callback is called at the end of this function
  init(callback = false) {
    //ASYNC DATA FETCH, but with a promise to be resolved
    Table.dataPrep.getRequestedData().then(function(resolver) {
      Table.sourceData[Table.dataType] = Table.dataPrep.prepareRequestedData(resolver);

      //Set datatables object
      let dataTableObject = {
        sDom: "<'table-body't><'table-footer'pli>",
        stateSave: true,
        lengthMenu: [
          [10, 15, 20, 40, -1],
          ["Mobile S(10)", "Mobile M(15)", "Mobile XL(20)", "Desktop(40)", "I'm a god(All)"]
        ],
        fixedColumns: true,
        data: Table.sourceData[Table.dataType],
        columns: [
          {
            data: "name",
            class: "name-col sellers-col",
            render(data, type) {
              if (Table.compareWithChat && type === "display") {
                 return data + "<span class='icon-desktop compare desktop'></span><br>" + "<span class='icon-terminal compare terminal'></span>";
              } else {
                return data;
              }
            }
          },
          {
            data: "min",
            class: "min-col",
            render(data, type, row, meta) {
              return Table.renders.chatValuesDisplay(row, type, "min");
            }
          },
          {
            data: "max",
            class: "max-col",
            visible: false,
            render(data, type, row, meta) {
              return Table.renders.chatValuesDisplay(row, type, "max");
            }
          },
          {
            data: "avg",
            class: "avg-col",
            render(data, type, row, meta) {
              return Table.renders.chatValuesDisplay(row, type, "avg");
            }
          },
          {
            data: "median",
            class: "median-col",
            render(data, type, row, meta) {
              return Table.renders.chatValuesDisplay(row, type, "median");
            }
          },
          {
            data: "mode",
            class: "mode-col"
          },
          {
            data: "ducat",
            visible: false,
            class: "ducats-col",
            defaultContent: 0
          },
          {
            class: "ratio-col",
            visible: false,
            render(data, type, row) {
              return Table.renders.ratio(data, type, row);
            }
          },
          {
            data: "orders",
            render(data, type, row) {
              return Table.renders.sellers(data, type, row);
            },
            class: "act-col",
            width: "100px",
            orderable: false,
            serchable: false
          },
          {
            data: "drop_location",
            visible: false,
            width: "100px",
            defaultContent: "",
            render(data, type, row) {
              return Table.renders.drop(data, type, row);
            }
          },
          {
            data: "market_pv_diff",
            visible: false,
            serchable: false,
            class: "save-plat",
            defaultContent: "UNKNOWN",
            render(data, type, row, meta) {
              const retu =  Table.renders.partsSumColumn(data, type, row, meta);
              return retu;
            }
          },
          {
            data: "item_type",
            visible: false
          },
          {
            data: "vaulted",
            visible: false,
            defaultContent: "not_vaulted",
            render(data, type, row) {
              return Table.renders.vaulted(data, type, row);
            }
          }
        ],
        //TODO:
        rowGroup: {
          dataSrc(a) {
            const nameParts = a.name.split(" ");
            let group = (typeof(nameParts[1]) !== "undefined") ? nameParts[0] + " " + nameParts[1] : nameParts[0];

            return group;
          },
          startRender: null,
          endRender(rows, group) {
            return Table.renders.groupNameEndRender(rows, group);
          }
        },
        language: {
          searchPlaceholder: "What do you need Tenno?"
        },
        //TODO
        createdRow: function(row, data, index) {
          if (data.vaulted) {
            $(row).find(".name-col").addClass("icon-lock");
          }
        },
        preDrawCallback(settings) {
          //Bug repairment with groups.
          //TODO: REPAIR THIS
          // if (settings.oLoadedState !== null) {
          //   if (settings.oLoadedState.order.length > 0) {
          //     if (settings.oLoadedState.order[0][0] > 0) {
          //       settings.rowGroup.disable();
          //     }
          //   } else {
          //     settings.rowGroup.disable();
          //   }
          // }
        }
      };


      Table.$elem = $("#dataTable").DataTable(dataTableObject);

      if (callback) {
        console.log(Table.$elem);
        callback();
      }
    });
  },
  reinit() {
    Table.$elem.clear().destroy();
    Table.init();
  },
  repopulate() {
    //TODO: All the dataprep stuff that changes the values before adding them to the table got ot be implemented inside the table callers so when i call Table.$elem.draw(false)
    // The table will calculate it all by itself without the need to clear the whole thing and add it again, thus improving the experience
    Table.$elem.clear();
    console.log(Table.$elem);
    let page = Table.$elem.page.info().page;
    Table.dataPrep.getRequestedData().then((resolver) => {
      Table.dataPrep.prepareRequestedData(resolver, function(dataSet) {
        Table.sourceData[Table.dataType] = dataSet;
        Table.$elem.rows.add(dataSet).draw();
        if (page > 0) {
          Table.$elem.page(page).draw("page");
        }
      });
    });
  }
};

export default Table;
