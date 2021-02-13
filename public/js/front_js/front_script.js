
// $("#sort").on('change',function(){
//     this.form.submit();

$("#sort").on('change',function(){
    var sort = $(this).val();
    var quality = get_filter("quality");
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{quality:quality,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })
});

$(".quality").on('click',function(){
    var quality = get_filter(this);
    var sort = $("#sort option:selected").val();
    var url = $("#url").val();
    $.ajax({
        url:url,
        method:"post",
        data:{quality:quality,sort:sort,url:url},
        success:function(data){
            $('.filter_products').html(data);
        }
    })


});

function get_filter(class_name){
    var filter = [];
    $('.'+class_name+ ':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}

