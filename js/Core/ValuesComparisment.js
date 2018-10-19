let ValuesComparisment = {
  "$elem": null,
  active: false,
  prepareData(data) {
    const dataCopy = JSON.parse(JSON.stringify(data));
    let set = [];

    $.each(dataCopy.labels, function(key, value) {

      set.push({
        date: value,
        min: dataCopy.min[key],
        max: dataCopy.max[key],
        avg: dataCopy.avg[key],
        median: dataCopy.median[key],
        mode: dataCopy.mode[key]
      });
    });

    return set;
  },
  renders: {
    date(data, type, row) {
        const indexT = row.date.indexOf("T");
        const year = row.date.substr(0, indexT);
        const time = row.date.substr(indexT + 1, 8);

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
        const column = ValuesComparisment.$elem.column($(this).val());
        column.visible(!column.visible());
      });
    },
    init() {
      ValuesComparisment.listners.columns();
    }
  },
  reinit(dataSet, item) {
    ValuesComparisment.active = item.id;
    ValuesComparisment.repopulate(ValuesComparisment.prepareData(dataSet));
  },
  init(dataSet, item) {
    if (ValuesComparisment.active) {
      ValuesComparisment.reinit(dataSet, item);
      return;
    }

    ValuesComparisment.active = item.id;

    let valuesTableObject = {
      sDom: "<'table-body't><'table-footer'pli>",
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
          class: "values-min-col"
        },
        {
          data: "max",
          class: "values-max-col",
          visible: false
        },
        {
          data: "avg",
          class: "values-avg-col"
        },
        {
          data: "median",
          class: "values-median-col"
        },
        {
          data: "mode",
          class: "values-mode-col"
        }
      ]
    };

    ValuesComparisment.$elem = $("#valuesTable").DataTable(valuesTableObject);
    ValuesComparisment.listners.init();
  }
};

export default ValuesComparisment;
