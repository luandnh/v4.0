let uIP = null;
$(function () {
    get_public_user_info().done((data) => {
        uIP = data.ip;
    });
});
get_public_user_info = () => {
    return $.ajax({
        type: "GET",
        url: "https://api.ipify.org/?format=json",
        async: true,
        headers: {
            "Content-Type": "application/json",
        },
    }).fail((xhr, status, error) => {
        console.log(xhr);
    });
};

delete_call_recording = async (fileid) => {
    swal(
        {
            title: `Are you sure to delete?`,
            text: "You will not be able to recover this call recording!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true,
        },
        function (isConfirm) {
            if (isConfirm) {
                const postData = {
                    goAction: "goDeleteCallRecording",
                    goUser: uName,
                    goPass: uPass,
                    log_ip: uIP,
                    log_user: uName,
                    log_pass: uPass,
                    responsetype: "json",
                    recording_id: fileid
                };
                
                $.ajax({
                    type: "POST",
                    url: "/goAPIv2/goCallRecordings/goAPI.php?"+$.param(postData),
                    processData: true,
                    datatype: "json",
                    async: true,
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .fail((request, status, error) => {
                        swal("Error", request.responseJSON.message, "error");
                        console.log(request);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    })
                    .done((data) => {
                        if (data.result !== undefined && data.result === "success") {
                            swal(
                                "Deleted!",
                                "Your recording file has been deleted.",
                                "success"
                            );
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }else{
                            swal("Error", data.result, "error");
                            console.log(request);
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    });
            } else {
                swal("Cancelled", "Your recording file is safe :)", "error");
            }
        }
    );
};
