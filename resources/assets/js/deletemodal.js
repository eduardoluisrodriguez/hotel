$(document).ready(function() {
    var row;

    $("#delete-modal").on("show.bs.modal", function(modal) {
        row = $(modal.relatedTarget).closest("tr");
        window.deleteId = $(modal.relatedTarget).data("id");
        var name = $(modal.relatedTarget).data("name");

        $(".modal-body strong:last").text(name);
    });

    $("#delete-confirm").click(function() {
        $("#delete-modal").modal("hide");
        $("#ajax-loading").show();

        $.ajax({
            url: $("#delete-modal").data("url") + window.deleteId,
            type: "POST",
            data: {_method: "delete", _token: $("meta[name='csrf-token']").attr("content")},
            success(data) {
                $("#alert-box").addClass(data.class);
                $("#alert-message").text(data.message);
                $("#alert-box").show();

                row.hide("slow", function() {
                    $(this).remove();
                });
            }
        });
    });
});
