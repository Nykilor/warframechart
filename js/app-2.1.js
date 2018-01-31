// TODO: VALUES TABLE COL HIDING, GRAPH STATE VISIBLE LINE SAVING, VALUES TABLE ROW CLICK TO GRAPH NODE FOCUS
/*eslint-disable */
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
/*eslint-enabled */

var doubleList = [
  "Akstiletto Prime Barrel",
  "Akstiletto Prime Receiver",
  "Ankyros Prime Blade",
  "Ankyros Prime Gauntlet",
  "Bo Prime Ornament",
  "Dual Kamas Prime Handle",
  "Dual Kamas Prime Blade",
  "Fang Prime Blade",
  "Fang Prime Handle",
  "Glaive Prime Blade",
  "Hikou Prime Pouch",
  "Hikou Prime Stars",
  "Orthos Prime Blade",
  "Spira Prime Blade",
  "Spira Prime Pouch",
  "Kogake Prime Boot",
  "Kogake Prime Gauntlet",
  "Akbolto Prime Receiver",
  "Akbolto Prime Barrel"
];

var partAmountList = {
  "Akbronco": 3,
  "Aklex": 3,
  "Akstiletto": 5,
  "Ankyros": 4,
  "Ash": 5,
  "Ballistica": 6,
  "Banshee": 5,
  "Bo": 4,
  "Boar": 5,
  "Boltor": 5,
  "Braton": 5,
  "Bronco": 4,
  "Burston": 5,
  "Carrier": 5,
  "Cernos": 6,
  "Dakra": 4,
  "Dual": 4,
  "Ember": 5,
  "Euphona": 4,
  "Fang": 4,
  "Fragor": 4,
  "Frost": 5,
  "Galatine": 4,
  "Glaive": 4,
  "Helios": 5,
  "Hikou": 4,
  "Hydroid": 5,
  "Kavasa": 4,
  "Latron": 5,
  "Lex": 4,
  "Loki": 5,
  "Mag": 5,
  "Nekros": 5,
  "Nikana": 4,
  "Nova": 5,
  "Nyx": 5,
  "Oberon": 5,
  "Odonata": 5,
  "Orthos": 4,
  "Paris": 6,
  "Rakta": 3,
  "Reaper": 4,
  "Rhino": 5,
  "Sancti": 3,
  "Saryn": 5,
  "Scindo": 4,
  "Secura": 3,
  "Sicarus": 4,
  "Silva": 5,
  "Soma": 5,
  "Spira": 4,
  "Sybaris": 5,
  "Synoid": 3,
  "Telos": 3,
  "Tigris": 5,
  "Trinity": 5,
  "Valkyr": 5,
  "Vasto": 4,
  "Vauban": 5,
  "Vaykor": 3,
  "Vectis": 5,
  "Venka": 4,
  "Volt": 5,
  "Wyrm": 5,
  "Nami": 3,
  "Mirage": 5,
  "Kogake": 4,
  "Akbolto": 5
};

var storage = {
  set(name, obj) {
    if (typeof(Storage) !== "undefined") {
      localStorage.setItem(name, JSON.stringify(obj));
    }
  },
  get(name) {
    if (typeof(Storage) !== "undefined" && localStorage.getItem(name) !== null) {
      return JSON.parse(localStorage.getItem(name));
    }
  }
}

/*eslint-disable */ //ESLINT IS A BITCH
Array.prototype.isMultidimensional = function () {
  for (var i = 0; i < this.length; i++) {
    if (this[i].constructor === Array) {
      return true;
      break;
    } else if (this.length - 1 === i) {
      return false;
    }
  }
};

Math.range = function (start, edge, step) {
  // If only one number was passed in make it the edge and 0 the start.
  if (arguments.length == 1) {
    edge = start;
    start = 0;
  }

  // Validate the edge and step numbers.
  edge = edge || 0;
  step = step || 1;

  // Create the array of numbers, stopping befor the edge.
  for (var ret = []; (edge - start) * step > 0; start += step) {
    ret.push(start);
  }
  return ret;
}

var middle = function (args) {
  if (!args.length) {
    return 0
  };
  var numbers = args.slice(0).sort((a, b) => a - b);
  var middle = Math.floor(numbers.length / 2);
  var isEven = numbers.length % 2 === 0;
  return isEven ? (numbers[middle] + numbers[middle - 1]) / 2 : numbers[middle];
}
/*eslint-enable */

//Without prefixes
var Dialog = function (dialogId, buttonId) {
  this.$elem = document.getElementById(dialogId);
  this.$elemId = "#" + dialogId;
  this.$buttonId = "#" + buttonId;

  return this;
};

Dialog.prototype.setBasicListners = function (openCallback = false, closeCallback = false) {
  var that = this;

  $(that.$buttonId).click(function() {
    $("body").css("overflow-y", "hidden");
    if(openCallback) openCallback();
    that.$elem.showModal();
    $(that.$elemId).scrollTop(0);
  });

  $(document).on("click", "dialog[open]", function (e) {
    if($(e.target).is("dialog")) {
      $("body").css("overflow-y", "inherit");
      if(closeCallback) closeCallback();
      that.$elem.close();
    }
  });

  return this;
};
//Jquery kind of with "."/"#" prefix
Dialog.prototype.setCloseButton = function ($closeBtn, closeCallback = false) {
  var that = this;
  $(this.$elemId + " " + $closeBtn).click(function() {
    $("body").css("overflow-y", "inherit");
    that.$elem.close();
    if(closeCallback) closeCallback();
  });

  return this;
};

//The Graphical representation of ValuesComparisment data
var CompChart = {
    //The <canvas> element
    "$elem": document.getElementById("chart"),
    //Cache for the data of items
    loadedData: {
      active: false,
      cache: {
        set(item) {
          CompChart.loadedData.cache[item] = {
            "sell": {
              "pc": false,
              "ps4": false,
              "xbox": false
            },
            "buy": {
              "pc": false,
              "ps4": false,
              "xbox": false
            }
          };
        }
      },
    },
    chart: {
      maxNodesPerDay: storage.get("chartMaxNodesPerDay") || 8,
      daysBack: storage.get("chartDaysBack") || 7,
      canvas: false,
      noAnimations: storage.get("chartNoAnimations") || false,
      config(dataSet) {
        return {
              type: 'line',
              data: {
                labels: dataSet["labels"],
                datasets: [
                  {
                    label: 'MIN',
                    data: dataSet["min"],
                    borderWidth: 1,
                    backgroundColor: "rgba(144, 238, 144, 0.5)",
                    borderColor: "rgba(144, 238, 144, 0.5)"
                  },
                  {
                    label: 'MAX',
                    data: dataSet["max"],
                    borderWidth: 1,
                    backgroundColor: "rgba(240, 128, 128, 0.5)",
                    borderColor: "rgba(240, 128, 128, 0.5)"
                  },
                  {
                    label: 'AVG',
                    data: dataSet["avg"],
                    borderWidth: 1,
                    backgroundColor: "rgba(211, 211, 211, 0.5)",
                    borderColor: "rgba(211, 211, 211, 0.5)"
                  },
                  {
                    label: 'MEDIAN',
                    data: dataSet["median"],
                    borderWidth: 1,
                    backgroundColor: "rgba(240, 248, 255, 0.5)",
                    borderColor: "rgba(240, 248, 255, 0.5)"
                  },
                  {
                    label: 'MODE',
                    data: dataSet["mode"],
                    borderWidth: 1,
                    backgroundColor: "rgba(193, 203, 255, 0.5)",
                    borderColor: "rgba(193, 203, 255, 0.5)"
                  }
              ]
              },
              options: {
                  maintainAspectRatio: false,
                  responsive: true,
                  elements: {
                    line: {
                      tension: 0
                    }
                  },
                  title:{
                      display:false
                  },
                  legend: {
                    position: "bottom",
                  },
                  tooltips: {
                      mode: 'index',
                      intersect: false,
                  },
                  hover: {
                      mode: 'nearest',
                      intersect: true
                  },
                  scales: {
                      xAxes: [{
                          autoSkip: false,
                          type: "time",
                          display: true,
                          time: {
                              unit: "day",
                              tooltipFormat: "h:mm ll"
                          },
                          scaleLabel: {
                              display: false,
                              labelString: 'Date'
                          }
                      }],
                      yAxes: [{
                          display: true,
                          scaleLabel: {
                              display: false,
                              labelString: 'The Value'
                          }
                      }]
                  }
              }
        }
      },
      addData(data) {
        var canvas = CompChart.chart.canvas;
        canvas.data.labels.push(...data["labels"]);

        canvas.data.datasets.forEach((set) => {
          set.data.push(...data[set.label.toLowerCase()]);
        });
      },
      clearData() {
        var canvas = CompChart.chart.canvas;
        canvas.data.labels.splice(0, canvas.data.labels.length);

        canvas.data.datasets.forEach(function (set) {
          set.data.splice(0, set.data.length);
        });
      },
      changeTitle(title) {
        var canvas = CompChart.chart.canvas;

        CompChart.chart.canvas.options.title.text = title;
      },
      //Loops trough the date_set and filters for specific nodes, i.e. 7 days back for max 6 nodes,
      // so the nodes will be from hours [0,4,8,12,16,20] (24 === 0)
      getFilteredSet(dataSet) {
        var today = new Date();
        var days_back = CompChart.chart.daysBack;
        var step = 24 / CompChart.chart.maxNodesPerDay;

        var hours_of_day = Math.range(0, 24, step);

        var last_day = null;
        var same_day = false;
        var set = {};

        var set_keys = Object.keys(dataSet);

        $.each(set_keys, function (a,b) {
          set[b] = [];
        });

        $.each(dataSet.labels, function (set_index,date) {
          var timeDiff = Math.abs(today.getTime() - date.getTime());
          var dayDiff = timeDiff / (1000*3600*24);

          if(dayDiff <= days_back) {
            if($.inArray(date.getHours(), hours_of_day) !== -1) {
              $.each(set_keys, function (a,b) {
                set[b].push(dataSet[b][set_index]);
              });
            }
          }
        });

        return set;
      },
      init(dataSet, title, force = false) {
        var ctx = CompChart.$elem;

        if(!CompChart.chart.canvas) {
          CompChart.chart.canvas = new Chart(ctx, CompChart.chart.config({
            labels: [],
            min: [],
            max: [],
            avg: [],
            median: [],
            mode: []
          }, title));
        } else {
          if(!force) {
            if(CompChart.loadedData.active !== title) {
              CompChart.loadedData.active = title;
              CompChart.chart.clearData();

              if(dataSet.labels.length > 0) {
                CompChart.chart.addData(dataSet);
              }

              CompChart.chart.changeTitle(title);
              CompChart.chart.canvas.update();
            }
          } else {
            CompChart.loadedData.active = title;
            CompChart.chart.clearData();

            if(dataSet.labels.length > 0) {
              CompChart.chart.addData(dataSet);
            }

            CompChart.chart.changeTitle(title);
            CompChart.chart.canvas.update();
          }

        }

      },
    },
    listners: {
      init() {
        var l = CompChart.listners;
        l.settings();
      },
      settings() {
        //Set basic
        $(".graph-options summary").prop("title", "Days: " + CompChart.chart.daysBack + ", Nodes: " + CompChart.chart.maxNodesPerDay);
        //Froce redraw of the chart
        var redraw = function () {
          var item = CompChart.loadedData.active;
          var platform = Table.orders.replace(":", "").toLowerCase();
          if(platform === "xb1") platform = "xbox";
          var dataSet = CompChart.loadedData.cache[item][Table.dataType][platform];

          CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item, true);
        };
        //Update input placeholder with current vlaues
        var setInput = function (input, key) {
          //set def
          var placeholder = $("#"+input).prop("placeholder");
          $("#"+input).prop("placeholder", placeholder + CompChart.chart[key]);
          //event
          $("#"+input).change(function () {
            var val = $(this).val();
            CompChart.chart[key] = val;
            storage.set(input, val);
            $(".graph-options summary").prop("title", "Days: " + CompChart.chart.daysBack + ", Nodes: " + CompChart.chart.maxNodesPerDay);
            redraw();
            $("#"+input).prop("placeholder", placeholder + CompChart.chart[key]);
          });
        };
        //Animations
        if(CompChart.chart.noAnimations) {
          CompChart.chart.canvas.options.animation.duration = 0;
          $("#chartAnimations").prop("checked", false);
        }
        $("#chartAnimations").change(function () {
          var val = !CompChart.chart.noAnimations;
          storage.set("chartNoAnimations", val);

          CompChart.chart.noAnimations = val;

          if(val) {
            CompChart.chart.canvas.options.animation.duration = 0;
          } else {
            CompChart.chart.canvas.options.animation.duration = 1000;
          }
        });

        setInput("chartDaysBack", "daysBack");
        setInput("chartMaxNodesPerDay", "maxNodesPerDay");
      }
    },
    //Collect chat data acording to meta of Table and passed arguments
    getChartData(item, platform, callback = false) {
      var dataSet = {
        "labels": [],
        "min": [],
        "max": [],
        "avg": [],
        "median": [],
        "mode": []
      };

      var resolve = function (dataSet, callback) {
        if(callback) {
          callback(dataSet);
        } else {
          return dataSet;
        }
      }

      $.getJSON("resources/json/market/"+Table.dataType+"/"+item+"/"+platform+"_graph.json").then(function (raw) {
        $.each(raw, function (date,stats) {
          var date_ar = date.split("_");
          var label = new Date(date_ar[3], date_ar[2]-1, date_ar[1], date_ar[0]);

          dataSet["labels"].push(label);
          //min,max,etc.
          $.each(stats, function (stats_key, value) {
            dataSet[stats_key].push(value);
          });

        });

        resolve(dataSet, callback);
      }).catch(function () {
        dataSet["empty"] = true;
        resolve(dataSet, callback);
      });
    },
    init() {
      $(".chart").toggle();
      if(typeof(Chart) === "undefined") {
        $.ajax({
          url:"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js",
          cache: true,
          dataType: "script"
        }).done(function () {
          CompChart.chart.init([[1,2,3]], "EMPTY");
          CompChart.listners.init();
        });
      } else {
        CompChart.chart.init([[1,2,3]], "EMPTY");
        CompChart.listners.init();
      }

    }
}

//The Table with all the values for item
var ValuesComparisment = {
  "$elem": null,
  active: false,
  prepareData(data) {
    var dataCopy = JSON.parse(JSON.stringify(data));
    var set = [];

    $.each(dataCopy["labels"], function (key, value) {

      set.push({
        date: value,
        min: dataCopy["min"][key],
        max: dataCopy["max"][key],
        avg: dataCopy["avg"][key],
        median: dataCopy["median"][key],
        mode: dataCopy["mode"][key],
      });
    });

    return set;
  },
  renders: {
    date(data, type, row) {
        var index_t = row.date.indexOf("T");
        var year = row.date.substr(0, index_t);
        var time = row.date.substr(index_t+1, 8);

        return year + ", " + time;
    }
  },
  repopulate(dataSet) {
    ValuesComparisment.$elem.clear();
    ValuesComparisment.$elem.rows.add(dataSet).draw();
  },
  listners: {
    columns() {
      $.each(ValuesComparisment.$elem.state().columns, function(a, b) {
        if (b.visible && a > 0) {
          $(".show-column-comparisment[value=" + a + "]").attr("checked", true);
        }
      });
      //handles event
      $(".show-column-comparisment").click(function() {
        var column = ValuesComparisment.$elem.column($(this).val());
        column.visible(!column.visible());
      });
    },
    init() {
      ValuesComparisment.listners.columns();
    }
  },
  init(dataSet, item) {
    //Like that to not change the structure of orginal
    if(ValuesComparisment.$elem !== null) {
      //repopulate
      if(ValuesComparisment.active !== item) {
        ValuesComparisment.repopulate(ValuesComparisment.prepareData(dataSet));
      }

      return;
    }

    ValuesComparisment.active = item;

    var valuesTableObject = {
      sDom: '<"table-body"t><"table-footer"pli>',
      stateSave: true,
      lengthMenu: [
        [10, 15, 20, 40, -1],
        ["Mobile S(10)", "Mobile M(15)", "Mobile XL(20)", "Desktop(40)", "I'm a god(All)"]
      ],
      fixedColumns: true,
      data: ValuesComparisment.prepareData(dataSet),
      columns: [
        {
          data: "date",
          class: "values-date-col",
          render(data, type, row) {
            return ValuesComparisment.renders.date(data, type, row);
          }
        },
        {
          data: "min",
          class: "values-min-col",
        },
        {
          data: "max",
          class: "values-max-col",
          visible: false,
        },
        {
          data: "avg",
          class: "values-avg-col",
        },
        {
          data: "median",
          class: "values-median-col",
        },
        {
          data: "mode",
          class: "values-mode-col"
        }
      ]
    };

    ValuesComparisment.$elem = $("#valuesTable").DataTable(valuesTableObject);
    ValuesComparisment.listners.init()
  }
}

//To engage the chat data
var ChatData = {
  init() {
    return $.get("resources/json/chat/" + Table.dataType + "/current.json");
  },
  getSingle(name) {
    return $.get("resources/json/chat/" + Table.dataType + "/" + name + "pc_graph.json");
  }
}

//The core table
var Table = {
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
  ratioCalcFrom: storage.get("ratioCalc") || "min",
  renders: {
    //returns a button with the count of sellers for platform
    sellers(data, type, row) {
      var order_count = 0;

      $.each(data, function(a) {
        if (a.indexOf(Table.orders) !== -1) {
          order_count++;
        }
      });
      var the_name = row.name;
      var the_group = row.name.split(" ")[0];
      var $button_orders = "<button class='sellers-btn icon-basket'>" + order_count + "</button>";
      var star = (Table.favourite.indexOf(the_name) !== -1) ? "icon-star-filled" : "icon-star";
      var group_like = (Table.favourite.indexOf(the_group) !== -1) ? " group-like" : "";
      var $button_fav = "<button class='favourite-btn " + star + group_like +"' data-group="+the_group+"></button>";

      return $button_orders + $button_fav;
    },
    //adds a row to show a table with listed sellers
    sellersList(data) {
      var orders = data.orders;
      var tbody = "";

      $.each(orders, function(a, b) {
        if (a.indexOf(Table.orders) !== -1) {
          var player_name = a.replace(Table.orders, "");
          if (typeof(b) === "number") {
            tbody = tbody + `<tr>
              <td><a href="https://warframe.market/profile/` + player_name + `" target="_blank">` + player_name + `</a></td>
              <td>` + b + `</td>
            </tr>`
          } else {
            tbody = tbody + `<tr>
              <td><a href="https://warframe.market/profile/` + player_name + `" target="_blank">` + player_name + `</a></td>
              <td>` + b[0] + ` - <small> R` + b[1] + `</small></td>
            </tr>`
          }
        }
      });

      var table = `<table class="inner-list-table">
        <thead>
          <tr>
            <th>PLAYER</th>
            <th>PRICE</th>
          </tr>
        </thead>
        <tbody>
        ` + tbody + `
        </tbody>
      </table>`;
      return table;
    },
    //returns modified row for chat values to be displayed
    chatValuesDisplay(values, type, key) {
      if(type === "display" && Table.compareWithChat) {
        var chat_key = "chat_"+key;
        var chat_value = (typeof(values[chat_key]) !== "undefined")? values[chat_key] : "?";
        var comparisment = values[key] + "<br>" + chat_value;
        return comparisment;
      } else {
        return values[key];
      }
    },
    //returns a html string for item groups that shows if parts or set is better deal
    groupNameEndRender(rows, group) {
      var items = rows.data();
      if (items.length === partAmountList[group]) {
        var sum = 0;
        var set = 0;
        for (var i = 0; i < items.length; i++) {
          if (items[i].name.indexOf("Set") !== -1) {
            set = items[i].min;
          } else {
            if (doubleList.indexOf(items[i].name) !== -1) {
              sum += items[i].min * 2;
            } else {
              sum += items[i].min;
            }
          }
        }
        if (set > 0 && sum > 0) {
          var msg = "";
          if (sum < set) {
            if (Table.dataType === "sell") {
              msg = "<small class='save success-save'><span class='icon-desktop'>" + (set - sum) + " P</span></small>";
            } else {
              msg = "<small class='save fail-save'><span class='icon-desktop'>" + (set - sum) + " P</span></small>";
            }
          } else {
            if (Table.dataType === "sell") {
              msg = "<small class='save success-save'><span class='icon-desktop'>" + (sum - set) + " S</span></small>";
            } else {
              msg = "<small class='save fail-save'><span class='icon-desktop'>" + (sum - set) + " S</span></small>";
            }
          }
          var star = (Table.favourite.indexOf(group) !== -1) ? "group-like" : "";
          return msg + `<button class="favourite-btn-all icon-star `+star+`" data-group="`+group+`">+</button>`;
        }
      }
    },
    //returns the plat:ducat ratio of signle items
    ratio(data, type, row) {
      var ratio = 0;

      if(typeof(row.ducats) !== "undefined") {
        ratio = Math.floor((row.ducats / row[Table.ratioCalcFrom]) * 10) / 10;
      }

      if(!isFinite(ratio)) ratio = 0;

      return ratio;
    },
    //returns the plat:ducat ratio to table for set treated as a group of items
    ducatSetSum(data, type, row, meta, dataSet) {
      var sum = data;

      if(row.name.indexOf("Set") !== -1) {
        var sum = 0;
        var group = row.name.split(" ")[0];
        var index_back = partAmountList[group];
        var row_set_index = meta.row;

        for (var i = 1; i < index_back; i++) {
          var part = dataSet[row_set_index - i];
          if(typeof(part.ducats) === "undefined") break;

          if(doubleList.indexOf(part.name) !== -1) {
            sum += part.ducats * 2;
          } else {
            sum += part.ducats;
          }
        }
        row.ducats = sum;
      }

      return sum;
    }
  },
  //All event listners
  listners: {
    init() {
      var l = Table.listners;
      l.showOrders();
      l.favourite();
      l.search();
      l.statValue();
      l.platform();
      l.dataType();
      l.column();
      l.ratioCalc();
      l.order();
      l.compareWithChatRow();

      //Chart
      l.showChart();
      l.loadGraphData();
      l.dialogChart();

      //ValuesComparisment
      l.showValuesComparisment();

      if(jQuery.browser.mobile) {
        //mobile-version
      } else {
        //desktop-version
        l.pageChange();
      }

    },
    //ValuesComparisment and Graph because of reasons.
    loadGraphData() {
      $("#dataTable tbody").on('click', 'tr[role="row"] td.name-col', function() {
        //Only if the user wants to fetch
        if(!App.CompChart) {
          if(!App.ValuesComparisment) return;
        }

        var $tr = $(this).parent();
        //If is offline and does not have cached class
        if(!App.connection.checkStatus()) {
          if(!$tr.hasClass("cached")) return;
        }


        var tagCached = function () {
          if(!$tr.hasClass("cached")) {
            $tr.addClass("cached");
          }
        }
        var item = $(this).text();
        var platform = Table.orders.replace(":", "").toLowerCase();
        if(platform === "xb1") platform = "xbox";

        if(typeof(CompChart.loadedData.cache[item]) === "undefined") {
          //Get the data and then
          CompChart.getChartData(item, platform, function (dataSet) {
            //Set basic cache
            CompChart.loadedData.cache.set(item);
            //Engage the extensions
            if(App.ValuesComparisment) ValuesComparisment.init(dataSet, item);
              //Cache the set
              //If the set does not have the key empty.
              if(typeof(dataSet["empty"]) === "undefined") {
                tagCached();
                CompChart.loadedData.cache[item][Table.dataType][platform] = dataSet;
              }
            if(App.CompChart) CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item);
          });
        } else {
          if(!CompChart.loadedData.cache[item][Table.dataType][platform]) {
            CompChart.getChartData(item, platform, function (dataSet) {
              if(App.ValuesComparisment) ValuesComparisment.init(dataSet, item);
              //If the set does not have the key empty.
              if(typeof(dataSet["empty"]) === "undefined") {
                CompChart.loadedData.cache[item][Table.dataType][platform] = dataSet;
                tagCached();
              }
              if(App.CompChart) CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item, true);
            });
          } else {
            var dataSet = CompChart.loadedData.cache[item][Table.dataType][platform];

            if(App.ValuesComparisment) ValuesComparisment.init(dataSet, item);
            if(App.CompChart) CompChart.chart.init(CompChart.chart.getFilteredSet(dataSet), item);
          }
        }

      });
    },
    showOrders() {
      var showSellers = function(elem) {
        var clicked_elem = elem;
        var table = Table.$elem;
        var tr = $(clicked_elem).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
        } else {
          // Open this row
          row.child(Table.renders.sellersList(row.data())).show();
          tr.addClass('shown');
        }
      };

      $("#dataTable tbody").on('click', ".sellers-btn", function() {
        showSellers(this);
      });
    },
    favourite() {
      $("#dataTable tbody").on('click', ".favourite-btn", function() {
        var tr = $(this).closest("tr");
        var row = Table.$elem.row(tr);
        var name = row.data().name;
        var fav_index = Table.favourite.indexOf(name);

        if (fav_index !== -1) {
          $(this).removeClass("icon-star-filled").addClass("icon-star");
          Table.favourite.splice(fav_index, 1);
        } else {
          $(this).addClass("icon-star-filled").removeClass("icon-star");
          Table.favourite.push(name);
        }

        storage.set("favourite", Table.favourite);

      });

      $("#dataTable tbody").on('click', ".favourite-btn-all", function() {
        var fav_what = $(this).data("group");
        var fav_index = Table.favourite.indexOf(fav_what);
        var group_elems = $('[data-group="'+fav_what+'"]');

        if (fav_index !== -1) {
          for (var i = 0; i < group_elems.length; i++) {
            $(group_elems[i]).removeClass("group-like");
          }
          Table.favourite.splice(fav_index, 1);
        } else {
          for (var iter = 0; iter < group_elems.length; iter++) {
            $(group_elems[iter]).addClass("group-like");
          }
          Table.favourite.push(fav_what);
        }
        storage.set("favourite", Table.favourite);
      });
    },
    search() {
      var $search = $("#search");
      var $search_fav = $("#show-fav");
      //last val
      $search.val(Table.$elem.state().search.search);

      var timeout = false;
      $search.on('input', function() {
        var val = this.value;
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          //"lith: v1 v2 v3" to "lith v1|lith v2|lith v3"
          if(val.indexOf(":") !== -1) {
            var val_ar = val.split(" ");
            var start_with = val_ar[0].replace(":", "");
            val_ar.splice(0, 1);
            val = start_with + " " + val_ar.join("|"+start_with+" ");
          }

          var isValid = true;
          try {
              new RegExp(val);
          } catch(e) {
              isValid = false;
          }

          if(isValid) {
            Table.$elem.search(val, true, false).draw();
          }
        }, 500);
      });

      $("body").keypress(function() {
        if (!$search.is(":focus")) {
          $search.focus();
        }
      });

      $search_fav.click(function() {
        var value = Table.favourite.join("|");
        //If the search is for it stop
        if ($search.val() === value) return;

        $search.val(value);
        Table.$elem.search(value, true, false).draw();
      });
    },
    column() {
      //sets default state
      $.each(Table.$elem.state().columns, function(a, b) {
        if (b.visible && a > 0 && a < 9) {
          $(".show-column[value=" + a + "]").attr("checked", true);
        }
      });
      //handles event
      $(".show-column").click(function() {
        var column = Table.$elem.column($(this).val());
        var order = Table.$elem.order();
        column.visible(!column.visible());

        if(typeof(order[0]) !== "undefined" && order[0][0] === 0) {
          Table.$elem.draw();
        }
      });
    },
    ratioCalc() {
      $('.ratio-calc[value="'+Table.ratioCalcFrom+'"]').attr("checked", true);

      $(".ratio-calc").click(function() {
        var calc_from = $(this).val();
        if(calc_from !== Table.ratioCalcFrom) {
          storage.set("ratioCalc", calc_from);
          Table.ratioCalcFrom = calc_from;
          Table.repopulate();
        }

      });
    },
    statValue() {
      if (Table.statValue) {
        $("#order-based input").attr("checked", true);
      }
      $(".value-type").click(function() {
        var value = parseInt($(this).val(), 10);

        if (Table.statValue === value) return;

        Table.statValue = value;
        storage.set("statValue", Table.statValue);
        Table.repopulate();
      });
    },
    platform() {
      if (Table.orders !== "PC:") {
        $('input[value="' + Table.orders + '"]').attr("checked", true);
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
      if (Table.dataType === "buy") $("input[value=buy]").attr("checked", true);
      $(".data-type").click(function() {
        if ($(this).val() !== Table.dataType) {
          Table.dataType = $(this).val();
          storage.set("dataType", Table.dataType);
          Table.repopulate();
        }
      });
    },
    dialogChart() {
      var $dialog = document.getElementById("chart-dialog");

      $("#dataTable tbody").on('click', 'tr[role="row"] td.name-col', function() {
        //Only if the user wants to fetch
        if(!App.CompChart) {
          if(!App.ValuesComparisment) return;
        }

        //If is offline and does not have cached class
        if(!App.connection.checkStatus()) {
          if(!$(this).parent().hasClass("cached")) return;
        }
        $("#chart-title").text($(this).text());
        $("body").css("overflow-y", "hidden");
        $dialog.showModal();
        $("#chart-dialog").scrollTop(0);
      });

      $(document).on("click", "dialog[open]", function (e) {
        if($(e.target).is("dialog")) {
          $("body").css("overflow-y", "inherit");
          $dialog.close();
        }
      });
    },
    order() {
      Table.$elem.on("order.dt", function() {
        var order = Table.$elem.order();
        if (order.length > 0) {
          var order_index = order[0][0];
          if (order_index > 0) {
            Table.$elem.rowGroup().disable();
          } else {
            Table.$elem.rowGroup().enable();
          }
        }
      });
    },
    compareWithChatRow() {
      $("#ChatData").change(function (e) {
        Table.compareWithChat = !Table.compareWithChat;
        storage.set("compareWithChat", Table.compareWithChat);
        Table.repopulate();
      });
    },
    showChart() {
      $("#CompChart").change(function () {
        App.CompChart = !App.CompChart;
        storage.set("CompChart", App.CompChart);
        if(typeof(Chart) === "undefined") {
          CompChart.init();
        } else {
          $(".chart").toggle();
        }
      });
    },
    showValuesComparisment() {
      $("#ValuesComparisment").change(function () {
        App.ValuesComparisment = !App.ValuesComparisment;
        storage.set("ValuesComparisment", App.ValuesComparisment);
        $(".values-comparisment").toggle();
      });
    },
    pageChange() {
      $(document).on("keydown", function (e) {
        if(!$("input").is(":focus") || !$("dialog").is("[open]")) {
          if(e.keyCode === 39) {
            Table.$elem.page("next").draw("page");
          } else if (e.keyCode === 37){
            Table.$elem.page("previous").draw("page");
          }
        }
      });
    }
  },
  dataPrep: {
    //array, function
    loop(dataSet, callback) {
      for (var i = 0; i < dataSet.length; i++) {
        callback(dataSet, i);
      }

      return dataSet;
    },
    //array, int, array
    chatValue(dataSet, i, chatData) {
      var item = dataSet[i];
      var itemChat = false;

      for (var i = 0; i < chatData.length; i++) {
        if(chatData[i].name === item.name) {
          itemChat = chatData[i];
          break;
        }
      }

      item.chat_min = itemChat.min;
      item.chat_max = itemChat.max;
      item.chat_avg = itemChat.avg;
      item.chat_median = itemChat.median;
    },
    getRequestedData() {
      return new Promise(function(resolve, reject) {
        return $.ajax({
          "url": "resources/json/market/" + Table.dataType + "/current.json",
          "dataType": "json",
          success(e) {
            marketData = e;
          },
          complete(e) {
            //The text top right
            var last_update = new Date(e.getResponseHeader('Last-Modified')).getTime();
            var time_now = new Date();
            var now = Math.floor((time_now.getTime() - last_update) / 60000);
            var $elem = $("#last-update");

            $elem.html("<span id='lastUpdate'>" + now + "</span> minutes ago.");
            var $update = $("#lastUpdate");
            //Update the "minutes ago time"
            setTimeout(function () {
              $update.text(parseInt($update.text())+1);
              setInterval(function () {
                $update.text(parseInt($update.text())+1);
              }, 60000);
            }, time_now.getSeconds() * 1000);
          }
        }).then(function(market) {
          //Overall preparation
            $.each(marketData, function (a,b) {
              var platform = Table.orders.replace(":", "").toLowerCase();
              if(platform === "xb1") platform = "xbox";

              if(Table.statValue) {
                b.min = b.min[platform];
                b.max = b.max[platform];
                b.avg = b.avg[platform];
                b.median = b.median[platform];
                b.mode = b.mode[platform];
              } else {
                var deleteZeros = function (variable) {
                  var values = [];
                  for (var i = 0; i < variable.length; i++) {
                    if(variable[i] !== 0) {
                      values.push(variable[i]);
                    }
                  }
                  return values;
                }

                var min_val = deleteZeros(Object.values(b.min));
                var max_val = deleteZeros(Object.values(b.max));
                var avg_val = deleteZeros(Object.values(b.avg));
                var median_val = deleteZeros(Object.values(b.median));
                var mode = deleteZeros(Object.values(b.mode));

                b.min = (min_val.length > 0)? Math.min(...min_val) : 0;
                b.max = (max_val.length > 0)? Math.max(...max_val) : 0;

                if(avg_val.length > 1) {
                  var sum = avg_val.reduce(function(a, b) { return a + b; });
                  var avg = sum / avg_val.length
                  b.avg = Math.floor(avg);
                } else {
                  b.avg = (typeof(avg_val[0]) !== "undefined")? avg_val[0] : 0;
                }

                //mode
                if(mode.length > 0) {
                  var mode_sum = mode.reduce(function (a,b) {
                    return a+b;
                  });

                  b.mode = Math.floor(mode_sum / mode.length);
                } else {
                  b.mode = 0;
                }


                //Profesional programing right here gentelmen
                median_val.sort();
                switch (median_val.length) {
                  case 3:
                    b.median = median_val[1];
                    break;
                  case 2:
                    b.median = (median_val[0] + median_val[1]) / 2;
                    break;
                  case 1:
                    b.median = median_val[0];
                    break;
                  case 0:
                    b.median = 0;
                    break;
                }
              }
            });
            if(Table.compareWithChat) {
              ChatData.init().then(function (chat) {
                //returns {"market": array, "chat": array}
                resolve({
                  "market": market,
                  "chat": chat
                });
              });
            } else {
              //returns array
              resolve({
                "market": market
              });
            }
        });
      });
    },
    prepareRequestedData(resolver, callback = false) {
        var market = resolver["market"];
        var chat = (typeof(resolver["chat"]) !== "undefined")? resolver["chat"] : false;

        //var passed to DataTable object
        var dataSet;

        //Set the variable
        if(Table.compareWithChat) {
          dataSet = Table.dataPrep.loop(market, function (set, i) {
            //If you want a comparisment do that
            if(chat) Table.dataPrep.chatValue(set, i, chat);
          });
        } else {
          dataSet = market;
        }

        if(callback) {
          callback(dataSet);
        } else {
          return dataSet;
        }
    }
  },
  //Callback is called at the end of this function
  init(callback = false) {
    //ASYNC DATA FETCH, but with a promise to be resolved
    Table.dataPrep.getRequestedData().then(function (resolver) {
      var dataSet = Table.dataPrep.prepareRequestedData(resolver);

      //Set datatables object
      var dataTableObject = {
        sDom: '<"table-body"t><"table-footer"pli>',
        stateSave: true,
        lengthMenu: [
          [10, 15, 20, 40, -1],
          ["Mobile S(10)", "Mobile M(15)", "Mobile XL(20)", "Desktop(40)", "I'm a god(All)"]
        ],
        fixedColumns: true,
        data: dataSet,
        columns: [
          {
            data: "name",
            class: "name-col sellers-col",
            render(data, type) {
              if(Table.compareWithChat && type === "display") {
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
            data: "ducats",
            visible: false,
            class: "ducats-col",
            defaultContent: 0,
            render(data, type, row, meta) {
              return Table.renders.ducatSetSum(data, type, row, meta, dataSet);
            }
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
            data: "relic",
            visible: false,
            defaultContent: "?"
          },
        ],
        rowGroup: {
          dataSrc(a) {
            return a.name.split(" ")[0];
          },
          startRender: null,
          endRender(rows, group) {
            return Table.renders.groupNameEndRender(rows, group);
          },
        },
        language: {
          searchPlaceholder: "What do you need Tenno?"
        },
        createdRow: function (row, data, index) {
          if(App.cacheStoragedItems.indexOf(data.name) !== -1) {
            $(row).addClass("cached");
          }
        },
        preDrawCallback(settings) {
          if(settings.oLoadedState !== null) {
            if(settings.oLoadedState["order"].length > 0) {
              if(settings.oLoadedState["order"][0][0] > 0) {
                settings.rowGroup.disable();
              }
            } else {
              settings.rowGroup.disable();
            }
          }
        }
      };

      /*eslint-disable */
      Table.$elem = $("#dataTable").DataTable(dataTableObject);
      /*eslint-enable */

      if(callback) callback();
    });
  },
  reinit() {
    Table.$elem.clear().destroy();
    Table.init();
  },
  repopulate() {
    Table.$elem.clear();
    Table.dataPrep.getRequestedData().then((resolver) => {
      Table.dataPrep.prepareRequestedData(resolver, function (dataSet) {
        Table.$elem.rows.add(dataSet).draw();
      });
    });
  }
}

//CompChart is for the graph representation of the data trough time
//ChatData is for showing a Chat to Market data Comparisment
//ValuesComparisment is for loading table of the data trought the time
var App = {
  Table: true,
  CompChart: storage.get("CompChart") || false,
  ValuesComparisment: storage.get("ValuesComparisment") || false,
  introJS: false,
  online: navigator.onLine,
  cacheStoragedItems: [],
  //Controller
  check_GET: {
    options: get.options,
    before() {
      $.each(this.options, function (key,value) {
        switch (key) {
          case "platform":
            if(["xb1", "ps4", "pc"].indexOf(value) !== -1) {
              var val = value.toUpperCase() + ":";
              Table.orders = val;
            }
            break;
          case "ratio":
            var index = ["min", "max", "avg", "median", "mode"].indexOf(value);
            if(index !== -1) {
              Table.ratioCalcFrom = value;
            }
            break;
          case "type":
            if(["sell","buy"].indexOf(value) !== -1) {
              Table.dataType = value;
            }
            break;
          case "values":
            if(value === "global") {
              Table.statValue = false;
            } else if(value === "platform") {
              Table.statValue = true;
            }
            break;
        }
      });
    },
    after() {
      $.each(this.options, function (key,value) {
        switch (key) {
          case "search":
            $("#search").val(value);
            $("#search").trigger("input");
            break;
          case "sort":
            var sorting = value.split(",");

            if(sorting.length > 2) return;

            Table.$elem.order([sorting]).draw();
            break;
          case "cols":
            var col_ar = value.split(",");

            //Shows indexed columns
            $.each(Table.$elem.columns().visible(), function (a,b) {
              if(a === 0) return;
              if(col_ar.indexOf(a.toString()) !== -1) {
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
    setCacheStoragedItems() {
      window.caches.open("app-v3-1").then(function(a) {
         a.keys().then(function (keys) {
           $.each(keys, function (a,b) {
             if(b.url.indexOf("graph") !== -1) {
               var url = b.url.substr(0,b.url.lastIndexOf("/"));
               var item = decodeURI(url.substr(url.lastIndexOf("/")+1));
               if(App.cacheStoragedItems.indexOf(item) === -1) {
                 App.cacheStoragedItems.push(item);
               }
             }
           });
         })
       });
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
      window.addEventListener('online', updateOnlineStatus);
      window.addEventListener('offline', updateOnlineStatus);
    }
  },
  listners: {
    shareBTN() {
      $("#share").click(function () {
        //basic
        var options = {
          platform: Table.orders.replace(":", "").toLowerCase(),
          type: Table.dataType,
          ratio: Table.ratioCalcFrom,
        };
        //order
        var order = Table.$elem.order()[0];
        if(typeof(order) !== "undefined") options.order = order.join(",");
        //search
        var search_q = $("#search").val();
        if(search_q.length > 0) options.search = search_q;
        //cols
        var cols_v = [];
        $.each(Table.$elem.columns().visible(), function (a,b) {
          if(a === 0) return;
          if(b) {
            cols_v.push(a);
          }
        });
        options.cols = cols_v.join(",");
        //values
        if(Table.statValue) {
          options.values = "global";
        } else {
          options.values = "platform";
        }

        var url = window.location.origin + window.location.pathname + "?";

        $.each(options, function (key,value) {
          if(typeof(value) !== "undefined") {
            url = url + key + "=" + value + "&";
          };
        });
        url = url.substr(0, url.length - 1);

        $(".share-copy-area").val(url);
        $(".share-copy-area").select();
        try {
          document.execCommand("copy");

          $(this).addClass("success");
          var that = this;
          setTimeout(function () {
            $(that).removeClass("success");
          }, 500);
        } catch (e) {
          alert("Unable to copy");
          console.warn(e);
        }

      });
    },
    dialogs() {
      //FAQ
      var faq = new Dialog("faq", "faq-help-open").setBasicListners();
      faq.setCloseButton(".dialog-close");

      //Builder
      var relic = false;
      var builder = new Dialog("relic-run", "build-relic-run").setBasicListners();

      $.getJSON("resources/json/worldState/relicByRelic.json").then(function (relics) {
        var string = [];
        $.each(relics, function (a,b) {

          string.push('<div class="type-'+a+'">');
          $.each(b, function(c,relic) {
            string.push('<label class="relic-type-label"><input type="checkbox" class="relic-type" name="type" value="'+relic+'" hidden><div class="type">'+relic+'</div></label>');
          });
          string.push('</div>');
        });
        $("#relic-run .types").html(string.join(""));
      });

      $(".relics-label input").click(function () {
        var show = $(this).val();
        relic = $(this);
        if(!$(".types .type-"+show).is(":visible")) {
          $("[class^='type-']").hide();
          $(".types .type-"+show).show();
        }
      });

      builder.setCloseButton(".dialog-close", function () {
        if(relic) {
          var types = [];
          $.each($(".relic-type:checked"), function (a,b) {
            $(b).prop("checked", false);
            types.push($(b).val());
          });

          relic.prop("checked", false);
          $("[class^='type-']").hide();

          var search_for = relic.val() + ":" + " " + types.join(" ");

          $("#search").val(search_for);
          $("#search").trigger("input");
        }
      });
    },
    detailsHideOnClick() {
      var hide = function (e, detailsClass) {
        if($(".introjs-helperLayer").length !== 0) return;
        var $elem = $(detailsClass);
        var $details = $(e.target).closest(detailsClass);

        if($details.length == 0) {
          if($elem.prop("open")) {
            $elem.prop("open", false);
          }
        }
      };
      $(document).click(function (e) {
        hide(e, ".details-drop");
        hide(e, ".filters-details");
      });
    },
    introJS() {
      $("#introJS").click(function () {
        var init = function (clear = false) {
          var $dialog = document.getElementById("faq");
          var $filters = $(".filters-details");
          var $loading = $(".details-drop");
          //clear the old attributes
          if(clear) {
            var clear_9 = $('[data-step="9"]');
            var clear_10 = $('[data-step="10"]');
            clear_9.removeAttr("data-step");
            clear_9.removeAttr("data-intro");
            clear_10.removeAttr("data-step");
            clear_10.removeAttr("data-intro");
          }

          var $fav_example = $(".favourite-btn:visible").first(); //10
          //Sort by item so we can target a element
          Table.$elem.order([0,"asc"]).draw();
          var $sum_part_example = $("table small.save:visible").first(); //9
          $("body").css("overflow-y", "inherit");
          $dialog.close();
          //set part 9
          $sum_part_example.attr("data-step", 9);
          $sum_part_example.attr("data-intro", "This 'short' shows you how much can you <span class='success-save'>save</span> by buying or <span class='fail-save'>lose</span> by selling (red background) Parts/Set, the P = parts, the S = set.");
          //set part 10
          $fav_example.attr("data-step", 10);
          $fav_example.attr("data-intro", "You can add single items to favourite list to quick access them by a button.");

          setTimeout(function () {
            introJs().setOption('showBullets', false).onchange(function (elem) {
              var step = $(elem).data("step");
              switch (step) {
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                  if(!$filters.prop("open")) {
                    $filters.prop("open", true);
                  }
                  break;
                case 7:
                  if($filters.prop("open")) {
                    $filters.prop("open", false);
                  }
                  break;
                case 9:
                  if(Table.$elem.order()[0][0] !== 0) {
                    Table.$elem.order([0,"asc"]).draw();
                  }
                  break;
                case 13:
                case 14:
                case 15:
                  if(!$loading.prop("open")) {
                    $loading.prop("open", true);
                  }
                  break;
                case 16:
                  if($loading.prop("open")) {
                    $loading.prop("open", false);
                  }
                  break;
              }
            }).start();
          }, 400);
        };
        if(App.introJS) {
          init(true);
        } else {
          $.ajax({
            url:"js/intro.min.js",
            cache: true,
            dataType: "script"
          }).done(function () {
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
    App.connection.setCacheStoragedItems();

    window.onbeforeprint = function() {
	     document.location.href = "nojs/"+Table.dataType+".html";
    }

    if(App.CompChart) {
      $("#CompChart").attr("checked", true);
      CompChart.init();
    }
    if(App.ValuesComparisment) {
      $("#ValuesComparisment").attr("checked", true);
      $(".values-comparisment").toggle();
    }
    if(Table.compareWithChat) $("#ChatData").attr("checked", true);

    App.listners.dialogs();
    App.listners.detailsHideOnClick();
    App.listners.introJS();
    App.check_GET.before();
    Table.init(function () {
      App.check_GET.after();
      Table.listners.init();
      App.listners.shareBTN();
      if(!App.online) {
        App.connection.handleOffline();
      }
    });
  }
}


$(document).ready(function() {
  App.init();
});
