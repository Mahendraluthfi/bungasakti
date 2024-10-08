"use strict";
$(document).ready(function () {
	$("#datatable").DataTable({
		columnDefs: [{ width: "1%", targets: 0 }],
	});
	var a = $("#datatable-buttons").DataTable({
		lengthChange: !1,
		buttons: ["copy", "print"],
	});
	$("#key-table").DataTable({ keys: !0 }),
		$("#responsive-datatable").DataTable(),
		$("#selection-datatable").DataTable({ select: { style: "multi" } }),
		$("#alternative-page-datatable").DataTable({ pagingType: "full_numbers" }),
		$("#scroll-vertical-datatable").DataTable({
			scrollY: "350px",
			searching: false,
			scrollCollapse: !0,
			columnDefs: [{ width: "1%", targets: 1 }],
			bInfo: false,
			paging: !1,
		}),
		$("#scroll-horizontal-datatable-zero").DataTable({
			scrollX: !0,
			order: [],
		}),
		$("#scroll-horizontal-datatable").DataTable({
			scrollX: !0,
			columnDefs: [{ width: "1%", targets: 0 }],
		}),
		$("#scroll-horizontal-datatable2").DataTable({
			scrollX: !0,
			columnDefs: [{ width: "1%", targets: 0 }],
		}),
		$("#complex-header-datatable").DataTable({
			columnDefs: [{ visible: !1, targets: -1 }],
		}),
		$("#row-callback-datatable").DataTable({
			createdRow: function (a, e, t) {
				15e4 < +e[5].replace(/[\$,]/g, "") &&
					$("td", a).eq(5).addClass("text-danger");
			},
		}),
		$("#state-saving-datatable").DataTable({ stateSave: !0 }),
		$("#fixed-columns-datatable").DataTable({
			scrollY: 300,
			scrollX: !0,
			scrollCollapse: !0,
			paging: !1,
			fixedColumns: !0,
		}),
		$("#fixed-header-datatable").DataTable({ responsive: !0 }),
		a
			.buttons()
			.container()
			.appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
		$("#datatable_length select[name*='datatable_length']").addClass(
			"form-select form-select-sm"
		),
		$("#datatable_length select[name*='datatable_length']").removeClass(
			"custom-select custom-select-sm"
		),
		$(".dataTables_length label").addClass("form-label");
});
