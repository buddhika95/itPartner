
// $("#sort").on('change',function(){
//     this.form.submit();

// const { size } = require("lodash");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#sort").on('change',function(){
    var sort = $(this).val();
    var quality = get_filter("quality");
    var warrenty = get_filter('warrenty');
    var freeitem = get_filter('freeitem');
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{quality:quality,warrenty:warrenty,freeitem:freeitem,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});

$(".quality").on('click',function(){
    var quality = get_filter('quality');
    var warrenty = get_filter('warrenty');
    var freeitem = get_filter('freeitem');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{quality:quality,warrenty:warrenty,freeitem:freeitem,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })


});

$(".warrenty").on('click',function(){
    var quality = get_filter('quality');
    var warrenty = get_filter('warrenty');
    var freeitem = get_filter('freeitem');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{quality:quality,warrenty:warrenty,freeitem:freeitem,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});

$(".freeitem").on('click',function(){
    var quality = get_filter('quality');
    var warrenty = get_filter('warrenty');
    var freeitem = get_filter('freeitem');
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{quality:quality,warrenty:warrenty,freeitem:freeitem,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
})



function get_filter(class_name){
    var filter = [];
    $('.'+class_name+ ':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}//Sorting ends here


$("#getPrice").change(function(){
    // alert("test");
    var type = $(this).val();
    if(type==""){
        alert("Please Select warrenty Type");
        return false;
    }
    var product_id = $(this).attr("product-id");
    $.ajax({
        url:'/get-product-price',
        data:{type:type,product_id:product_id},
        type:'post',
        success:function(resp){
            // alert(resp['product_price']);
            // alert(resp['discounted_price']);
            // return false;
            if(resp['discount']>0){
                $(".getAttrPrice").html("<del>Rs. "+resp['product_price']+".00"+"</del> Rs. "+resp['final_price']+".00");
            }else{
                $(".getAttrPrice").html("Rs. "+resp['product_price']+".00");
            }

        },error:function(){
            alert("Error");
        }
    });
});

//update cart items
$(document).on('click','.btnItemUpdate',function(){
    if($(this).hasClass('qtyMinus')){
        // if miunus button click by user
        var quantity = $(this).prev().val();
        if( quantity<=0){
            alert("Item quantity must be 1 or greater!");
            return false;
        }else{
            new_qty=parseInt(quantity)-1;
        }
    }
    if($(this).hasClass('qtyPlus')){
    // if  plus button click by user
        var quantity = $(this).prev().prev().val();
        new_qty=parseInt(quantity)+1;
    }

    var cartid=$(this).data('cartid');

    $.ajax({
        data:{"cartid":cartid,"qty":new_qty},
        url:'/update-cart-item-qty',
        type:'post',
        success:function(resp){
            if(resp.status==false){
                alert(resp.message);
            }

            $("#AppendCartItems").html(resp.view);
        },error:function(){
            alert("Error");
        }

    });
});

//Delete cart items
$(document).on('click','.btnItemDelete',function(){
    var cartid=$(this).data('cartid');
    var result = confirm("Do you Want to delete this Cart Item");
    if(result){
        $.ajax({
            data:{"cartid":cartid},
            url:'/delete-cart-item',
            type:'post',
            success:function(resp){
                $("#AppendCartItems").html(resp.view);
            },error:function(){
                alert("Error");
            }

        });
    }

});

	// validate Register form on keyup and submit
    $("#registerForm").validate({
        rules: {
            name: "required",
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },

            email: {
                required: true,
                email: true,
                remote:"check-email"
            },
            password: {
                required: true,
                minlength: 6
            }
        },

        messages: {
            name: "Please enter your name",

            mobile: {
                required: "Please enter a Mobile No",
                minlength: "Your Mobile No must consist of at least 10 Digits",
                maxlength: "Your Mobile No must consist of at least 10 Digits",
                digits: "please enter a valid mobile no"
            },
            email: {
                required:"Please enter a valid email address",
                email:"Please enter a valid email address",
                remote:"Email Already Exists Please try another Email"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
        }
    });

    // validate Login form on keyup and submit
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,

            },
            password: {
                required: true,
                minlength: 6
            }
        },

        messages: {
            email: {
                required:"Please enter your email address",
                email:"Please enter a valid email address"

            },
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 6 characters long"
            },
        }
    });


