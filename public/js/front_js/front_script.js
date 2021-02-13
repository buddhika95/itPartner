
// $("#sort").on('change',function(){
//     this.form.submit();

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
}

