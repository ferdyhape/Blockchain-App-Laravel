$(document).ready(function () {
    // $('input[name="paymentMethod"]').change(function () {
    //     let paymentMethodId = $(this).val();
    //     console.log("Selected payment method ID:", paymentMethodId);
    //     $.ajax({
    //         url: getPaymentMethodDetailUrl,
    //         type: "GET",
    //         data: {
    //             paymentMethodId: paymentMethodId,
    //         },
    //         success: function (response) {
    //             let accordionContent = $("#paymentMethodDetailAccordion");
    //             accordionContent.empty();
    //             if (response.data.length > 0) {
    //                 let content = response.data
    //                     .map(
    //                         (detail, index) => `
    //                                     <div class="accordion-item">
    //                                         <h2 class="accordion-header" id="heading${index}">
    //                                             <button class="accordion-button ${
    //                                                 index !== 0
    //                                                     ? "collapsed"
    //                                                     : ""
    //                                             }" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${
    //                             index === 0
    //                         }" aria-controls="collapse${index}">
    //                                                 ${detail.name}
    //                                             </button>
    //                                         </h2>
    //                                         <div id="collapse${index}" class="accordion-collapse collapse ${
    //                             index === 0 ? "show" : ""
    //                         }" aria-labelledby="heading${index}" data-bs-parent="#paymentMethodDetailAccordion">
    //                                             <div class="accordion-body px-5 d-flex flex-column">
    //                                                 <p class="">
    //                                                     ${detail.description}
    //                                                 </p>
    //                                                 <button class="btn btn-primary mt-2 select-payment-method-detail"
    //                                                     data-payment-method-id="${
    //                                                         detail.id
    //                                                     }">Pilih</button>
    //                                             </div>
    //                                         </div>
    //                                     </div>
    //                                 `
    //                     )
    //                     .join("");
    //                 accordionContent.html(content).show();
    //             } else {
    //                 accordionContent.hide();
    //             }
    //         },
    //         error: function (error) {
    //             $("#paymentMethodDetailAccordion")
    //                 .html("<p>Error fetching payment method details</p>")
    //                 .show();
    //         },
    //     });
    // });

    $(document).on("click", "#next-button-buy", function () {
        // let paymentMethodId = $(this).data("payment-method-id");

        // $.ajax({
        //     url: routeBuyProject,
        //     type: "POST",
        //     data: {
        //         campaign_id: campaignId,
        //         quantity: quantityBuy,
        //         // payment_method_detail_id: paymentMethodId,
        //     },
        //     success: function (response) {
        //         console.log(response);
        //         window.location.href = response.redirect;
        //     },
        //     error: function (error) {
        //         console.log(error.responseJSON.message);
        //         showAlert(error.responseJSON.message, "error");
        //     },
        // });

        // add confirmation with sweetalert

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Anda akan membeli sesuai detail yang telah ditampilkan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Lanjutkan!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: routeBuyProject,
                    type: "POST",
                    data: {
                        campaign_id: campaignId,
                        quantity: quantityBuy,
                        // payment_method_detail_id: paymentMethodId,
                    },
                    success: function (response) {
                        console.log(response);
                        window.location.href = response.redirect;
                    },
                    error: function (error) {
                        console.log(error.responseJSON.message);
                        showAlert(error.responseJSON.message, "error");
                    },
                });
            }
        });
    });
});
