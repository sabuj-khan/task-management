;(function($){
    $(document).ready(function(){

        $(".complete").on('click', function(){
            var id = $(this).data("taskid");
            $("#ctaskid").val(id);
            $("#formcomplete").submit();
        });

        $(".delete").on('click', function(){
            if(confirm("Are you sure to delete this task?")){
                var id = $(this).data("taskid");
                $("#dtaskid").val(id);
                $("#formdelete").submit();
            }
        });

        $(".incomplete").on('click', function(){
            var id = $(this).data("taskid");
            $("#incomid").val(id);
            $("#incomplete").submit();
            
        });

        $("#bulkdelete").on('click', function(){
            if($("#action").val() == 'bulkdelete'){
                if(!confirm("Are you sure to delete")){
                    return false;
                }
            }
        });

        
    })

})(jQuery)