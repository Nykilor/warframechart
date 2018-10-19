/* globals Chart */
import { storage, createRange, createYMDDate } from "./../utilities.js";
import Table from "./Table.js";
import App from "./App.js";
import MarketData from "./MarketData.js";
import ValuesComparisment from "./ValuesComparisment.js";

let CompChart = {
    //The <canvas> element
    "$elem": document.getElementById("chart"),
    //Cache for the data of items
    loadedData: {
      active: false,
      cache: {
        set(item) {
          CompChart.loadedData.cache[item] = {
            "sell": {
              "pc": {
                "data": false,
                "daysLoaded": 0
              },
              "ps4": {
                "data": false,
                "daysLoaded": 0
              },
              "xbox": {
                "data": false,
                "daysLoaded": 0
              }
            },
            "buy": {
              "pc": {
                "data": false,
                "daysLoaded": 0
              },
              "ps4": {
                "data": false,
                "daysLoaded": 0
              },
              "xbox": {
                "data": false,
                "daysLoaded": 0
              }
            }
          };
        }
      }
    },
    chart: {
      maxNodesPerDay: storage.get("chartMaxNodesPerDay") || 8,
      daysBack: storage.get("chartDaysBack") || 7,
      canvas: false,
      noAnimations: storage.get("chartNoAnimations") || false,
      config(dataSet) {
        const font = parseInt($("body").css("font-size"));
        return {
              type: "line",
              data: {
                labels: dataSet.labels,
                datasets: [
                  {
                    label: "MIN",
                    data: dataSet.min,
                    borderWidth: 1,
                    backgroundColor: "rgba(144, 238, 144, 0.5)",
                    borderColor: "rgba(144, 238, 144, 0.5)"
                  },
                  {
                    label: "MAX",
                    data: dataSet.max,
                    borderWidth: 1,
                    backgroundColor: "rgba(240, 128, 128, 0.5)",
                    borderColor: "rgba(240, 128, 128, 0.5)"
                  },
                  {
                    label: "AVG",
                    data: dataSet.avg,
                    borderWidth: 1,
                    backgroundColor: "rgba(211, 211, 211, 0.5)",
                    borderColor: "rgba(211, 211, 211, 0.5)"
                  },
                  {
                    label: "MEDIAN",
                    data: dataSet.median,
                    borderWidth: 1,
                    backgroundColor: "rgba(240, 248, 255, 0.5)",
                    borderColor: "rgba(240, 248, 255, 0.5)"
                  },
                  {
                    label: "MODE",
                    data: dataSet.mode,
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
                  title: {
                      display: false
                  },
                  legend: {
                    position: "bottom",
                    labels: {
                      fontSize: font
                    }
                  },
                  tooltips: {
                      mode: "index",
                      intersect: false,
                      bodyFontSize: font,
                      titleFontSize: font
                  },
                  hover: {
                      mode: "nearest",
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
                          ticks: {
                              autoSkip: true,
                              maxTicksLimit: 20,
                              fontSize: font
                          },
                          scaleLabel: {
                              display: false,
                              labelString: "Date"
                          }
                      }],
                      yAxes: [{
                          display: true,
                          scaleLabel: {
                              display: false,
                              labelString: "The Value"
                          },
                          ticks: {
                            fontSize: font
                          }
                      }]
                  }
              }
        };
      },
      addData(data) {
        let canvas = CompChart.chart.canvas;
        canvas.data.labels.push(...data.labels);

        canvas.data.datasets.forEach((set) => {
          set.data.push(...data[set.label.toLowerCase()]);
        });
      },
      clearData() {
        let canvas = CompChart.chart.canvas;
        canvas.data.labels.splice(0, canvas.data.labels.length);

        canvas.data.datasets.forEach(function(set) {
          set.data.splice(0, set.data.length);
        });
      },
      changeTitle(title) {
        CompChart.chart.canvas.options.title.text = title;
      },
      //Loops trough the date_set and filters for specific nodes, i.e. 7 days back for max 6 nodes,
      // so the nodes will be from hours [0,4,8,12,16,20] (24 === 0)
      getFilteredSet(dataSet) {
        if (typeof(dataSet.empty) !== "undefined" && dataSet.empty) {
          return dataSet;
        }
        //// TODO: ALL BELOW
        const today = new Date();
        const daysBack = CompChart.chart.daysBack;
        let step = 24 / CompChart.chart.maxNodesPerDay;

        let hoursOfDay = createRange(0, 24, step);
        let set = {};

        const setKeys = Object.keys(dataSet);

        $.each(setKeys, function(a, b) {
          set[b] = [];
        });

        $.each(dataSet.labels, function(setIndex, date) {
          let timeDiff = Math.abs(today.getTime() - date.getTime());
          let dayDiff = timeDiff / (1000 * 3600 * 24);

          if (dayDiff <= daysBack) {
            if ($.inArray(date.getHours(), hoursOfDay) !== -1) {
              $.each(setKeys, function(a, b) {
                set[b].push(dataSet[b][setIndex]);
              });
            }
          }
        });

        return set;
      },
      init(dataSet, item, force = false) {
        let ctx = CompChart.$elem;
        const title = item.name;
        if (!CompChart.chart.canvas) {
          CompChart.chart.canvas = new Chart(ctx, CompChart.chart.config({
            labels: [],
            min: [],
            max: [],
            avg: [],
            median: [],
            mode: []
          }, title));
        } else {
          if (!force) {
            if (CompChart.loadedData.active.id !== item.id) {
              CompChart.loadedData.active = item;
              CompChart.chart.clearData();

              if (dataSet.labels.length > 0) {
                CompChart.chart.addData(dataSet);
              }

              CompChart.chart.changeTitle(title);
              CompChart.chart.canvas.update();
            }
          } else {
            CompChart.loadedData.active = item;
            CompChart.chart.clearData();

            if (dataSet.labels.length > 0) {
              CompChart.chart.addData(dataSet);
            }

            CompChart.chart.changeTitle(title);
            CompChart.chart.canvas.update();
          }

        }
      }
    },
    listners: {
      init() {
        let l = CompChart.listners;
        l.settings();
      },
      settings() {
        //Set basic
        $(".graph-options summary").prop("title", "Days: " + CompChart.chart.daysBack + ", Nodes: " + CompChart.chart.maxNodesPerDay);
        //Froce redraw of the chart
          let redraw = function(inRange = false, diffrence = 0) {
          let item = CompChart.loadedData.active;
          let platform = Table.orders.replace(":", "").toLowerCase();
          platform = (platform === "xb1") ? "xbox" : platform;
          let dataSet = CompChart.loadedData.cache[item.id][Table.dataType][platform].data;

          if (inRange) {

            if (!dataSet) {
              dataSet = {
                labels: [],
                min: [],
                max: [],
                avg: [],
                median: [],
                mode: [],
                empty: true
              };
            }
          } else {
            let start = createYMDDate(-CompChart.chart.daysBack);
            //end got to be the start from last fetch
            let end = createYMDDate(-(CompChart.chart.daysBack - diffrence));
            //Call the getData to fetch the diffrence, join it and show it to the audience
            CompChart.getChartData(item.id, platform, function(dataSet) {
              //If the set does not have the key empty.
              let cachedData = CompChart.loadedData.cache[item.id][Table.dataType][platform].data;
              if (typeof(dataSet.empty) === "undefined") {

                if (!cachedData) {
                  cachedData = {};
                }

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
            }, start, end);
          }

          if (dataSet) {
            let filtered = CompChart.chart.getFilteredSet(dataSet);
            if (App.ValuesComparisment) {
              ValuesComparisment.init(filtered, item);
            }
            CompChart.chart.init(filtered, item, true);
          }
        };
        let timeout = false;
        //Update input placeholder with current vlaues
        let setInput = function(input, key) {
          //set def
          const placeholder = $("#" + input).prop("placeholder");
          $("#" + input).prop("placeholder", placeholder + CompChart.chart[key]);
          //event
          $("#" + input).bind("keyup change", function() {
            //This breaks so badly if you don't parseInt
            const val = parseInt($(this).val());
            const item = CompChart.loadedData.active;

            let platform = Table.orders.replace(":", "").toLowerCase();
            platform =  (platform === "xb1") ? "xbox" : platform;
            let inRange = false;
            let diffrence = 0;

            let timeOutfetchAndRedraw = function() {
              timeout = setTimeout(function() {
                console.log("Timeout called");
                console.log(inRange);
                if (key !== "maxNodesPerDay") {
                  //Same thing here.
                  let cacheDaysLoaded = parseInt(CompChart.loadedData.cache[item.id][Table.dataType][platform].daysLoaded);
                  let maxNodesCached = parseInt(CompChart.chart[key]);
                  if (val <= maxNodesCached  || val <= cacheDaysLoaded) {
                    inRange = true;
                  } else {
                    diffrence = val - maxNodesCached;
                  }
                } else {
                  inRange = true;
                }
                CompChart.chart[key] = val;
                storage.set(input, val);
                $(".graph-options summary").prop("title", "Days: " + CompChart.chart.daysBack + ", Nodes: " + CompChart.chart.maxNodesPerDay);
                redraw(inRange, diffrence);
                $("#" + input).prop("placeholder", placeholder + CompChart.chart[key]);
              }, 500);
            };
            if (timeout) {
              clearTimeout(timeout);
              timeOutfetchAndRedraw();
            } else {
              timeOutfetchAndRedraw();
            }
          });
        };
        //Animations
        if (CompChart.chart.noAnimations) {
          CompChart.chart.canvas.options.animation.duration = 0;
          $("#chartAnimations").prop("checked", false);
        }
        $("#chartAnimations").change(function() {
          const val = !CompChart.chart.noAnimations;
          storage.set("chartNoAnimations", val);

          CompChart.chart.noAnimations = val;

          if (val) {
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
    getChartData(id, platform, callback = false, customStart = false, customEnd = false) {
      let dataSet = {
        "labels": [],
        "min": [],
        "max": [],
        "avg": [],
        "median": [],
        "mode": []
      };

      let resolve = function(dataSet, callback) {
        if (callback) {
          callback(dataSet);
        } else {
          return dataSet;
        }
      };

      let start = new Date();
      if (!customStart) {
        start = createYMDDate(-CompChart.chart.daysBack);
      } else {
        start = customStart;
      }

      let end = new Date();
      if (!customEnd) {
        end = createYMDDate(1);
      } else {
        end = customEnd;
      }

      MarketData.getItemRangeData(Table.dataType, id, platform, end, start).then(function(raw) {
        if (typeof(raw) !== "undefined") {
          $.each(raw.response, function(key, value) {
            //Because the app works in this timezone
            dataSet.labels.push(new Date(value.date.date + " " + App.timezone));
            //min,max,etc.
            $.each(dataSet, function(statsKey) {
              if (statsKey !== "labels") {
                dataSet[statsKey].push(value[platform + "_" + statsKey]);
              }
            });
          });
        } else {
          dataSet.empty = true;
        }
        resolve(dataSet, callback);
      }).catch(function() {
        dataSet.empty = true;
        resolve(dataSet, callback);
      });
    },
    init() {
      $(".chart").toggle();
      if (typeof(Chart) === "undefined") {
        $.ajax({
          url: "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js",
          cache: true,
          dataType: "script"
        }).done(function() {
          CompChart.chart.init([[1, 2, 3]], "EMPTY");
          CompChart.listners.init();
        });
      } else {
        CompChart.chart.init([[1, 2, 3]], "EMPTY");
        CompChart.listners.init();
      }

    }
};
export default CompChart;
