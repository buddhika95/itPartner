// Check Admin Password is correct or not
 $("#current_pwd").keyup(function(){
  var current_pwd = $("#current_pwd").val();
  //alert(current_pwd);
  $.ajax({
   type:'post',
   url:'/admin/check-current-pwd',
   data:{current_pwd:current_pwd},
   success:function(resp){
    if(resp=="false"){
     $("#chkCurrentPwd").html("<font color=red>Current Password is incorrect</font>");
    }else if(resp=="true"){
     $("#chkCurrentPwd").html("<font color=green>Current Password is correct</font>");
    }
   },error:function(){
    alert("Error");
   }
  });
 });

//update category Status
 $(".updateSectionStatus").click(function(){
    var status=$(this).text();
    var section_id =$(this).attr("section_id");
    $.ajax({
        type:'post',
        url:'/admin/update-section-status',
        data:{status:status,section_id:section_id},
        success:function(resp){
            if(resp['status']==0){
                $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'> InActive</a>");
            }else if(resp['status']==1){
                $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'> Active</a>");
            }

        },error:function(){
            alert("Error");
        }
    });
});

//update category Status
$(".updateCategoryStatus").click(function(){
    var status=$(this).text();
    var category_id =$(this).attr("category_id");
    $.ajax({
        type:'post',
        url:'/admin/update-category-status',
        data:{status:status,category_id:category_id},
        success:function(resp){
            if(resp['status']==0){
                $("#category-"+section_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'> InActive</a>");
            }else if(resp['status']==1){
                $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'> Active</a>");
            }

        },error:function(){
            alert("Error");
        }
    });
});

//Append categories Level
$('#section_id').change(function(){
    var section_id = $(this).val();
    alert(section_id);
    $.ajax({
        type:'post',
        url:'/admin/append-categories-level',
        data:{section_id:section_id},
        success:function(resp){
            $("#appendCategoriesLevel").html(resp);
        },error:function(){
            alert("Error");
        }
    });
});

//Confirm Deletetion for records
// $(".confirmDelete").click(function(){
//     var name = $(this).attr("name");
//     if(confirm("Are you Sure to delete this "+name+"?"))
//     {
//         return true;

//     }
//     return false;

// });
//confirm delete with sweet  alert
$(".confirmDelete").click(function(){
    var record = $(this).attr("record");
    var recordid = $(this).attr("recordid");

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
          window.location.href="/admin/delete-"+record+"/"+recordid;

        }
      });
});


//Product jquerries
//update product Status
$(".updateProductStatus").click(function(){
    var status=$(this).text();
    var product_id =$(this).attr("product_id");
    $.ajax({
        type:'post',
        url:'/admin/update-product-status',
        data:{status:status,product_id:product_id},
        success:function(resp){
            if(resp['status']==0){
                $("#product-"+section_id).html("<a class='updateProductStatus' href='javascript:void(0)'> InActive</a>");
            }else if(resp['status']==1){
                $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'> Active</a>");
            }

        },error:function(){
            alert("Error");
        }
    });
});
