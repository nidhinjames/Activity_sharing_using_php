<script type="text/javascript">

jQuery.fn.ajaxpagination = function(totaldata, current, data_per_page, pagelimit, url, divid, data)
{
    var prev = 0;
    var next = 0;
    var left_balance = 0;
    var right_balance = 0;
    
    if(pagelimit % 2 ==1)
    {
        var left_pages =  Math.round((pagelimit-1)/2);
        var right_pages = Math.round(pagelimit/2);
    }
    else
    {
        var left_pages =  Math.round(pagelimit/2);
        var right_pages = Math.round(pagelimit/2);
    }
    var limitfrom = (parseInt(current) * parseInt(data_per_page)) - parseInt(data_per_page);
    var limitto = data_per_page;
    //alert(left_pages+','+right_pages);    
    this.each(function()
    {
        $(this).html("");
        //var dataString = "totaldata="+totaldata;
        var dataString = "start="+limitfrom+"&end="+limitto+"&"+data;
        $.ajax({
        type: "POST",
        url: url,
        data: dataString,
        success: function(response)
        {  
            //alert(response);
               
            $("#"+divid).html(response);    
        }
      });
        
        if(totaldata > data_per_page)
        {
            var noofpage = Math.ceil(totaldata/data_per_page);
            //alert(noofpage);    
            if(noofpage < pagelimit)
            {
                pagelimit = noofpage;
            }
            var pagestart = parseInt(current) - (left_pages);
            if(pagestart <= 0)
            {
                left_balance = 0 - parseInt(pagestart);
                pagestart=1;
                pageend = parseInt(current) + parseInt(right_pages) +parseInt(left_balance);
            }
            else
            {
                pageend = parseInt(current) + parseInt(right_pages);
            }
            if(pageend > noofpage)
            {
                right_balance = parseInt(pageend) - parseInt(noofpage);
                pageend = noofpage;
                
            }
            if(right_balance > 0)
            {
                pagestart = (parseInt(current)-(parseInt(left_pages) + parseInt(right_balance))+1);
                if(pagestart <= 0)
                {
                    pagestart=1;
                }
            }
            if(left_balance == 0 && right_balance==0)
            {
                if((current-left_pages) !=0)
                {
                    pageend = parseInt(pageend) -1;
                }
            }
                prev = parseInt(current) - 1;
                next = parseInt(current) + 1;
                if( pagestart > 1)
                {
                    $(this).append("<li style='cursor:pointer;' onclick=callplugin("+totaldata+","+1+","+data_per_page+","+pagelimit+",'"+url+"','"+divid+"','"+data+"');><a>First</a></li>");
                }
                
                if(current !=1)
                {
                    $(this).append("<li style='cursor:pointer;' onclick=callplugin("+totaldata+","+prev+","+data_per_page+","+pagelimit+",'"+url+"','"+divid+"','"+data+"');><a>Prev</a></li>");
                }
                
                for(var j=pagestart; j<=pageend; j++)
                {
                    if(j == current)
                    {
                        $(this).append("<li id='currentpage' style='cursor:pointer;' onclick=callplugin("+totaldata+","+j+","+data_per_page+","+pagelimit+",'"+url+"','"+divid+"','"+data+"');><a>"+j+"</a></li>");
                    }
                    else
                    {
                        $(this).append("<li style='cursor:pointer;' onclick=callplugin("+totaldata+","+j+","+data_per_page+","+pagelimit+",'"+url+"','"+divid+"','"+data+"');><a>"+j+"</a></li>");
                    }        
                }
                
                if(current !=noofpage)
                {
                    $(this).append("<li style='cursor:pointer;' onclick=callplugin("+totaldata+","+next+","+data_per_page+","+pagelimit+",'"+url+"','"+divid+"','"+data+"');><a>Next<a></li>");
                }
            
                if( pageend < noofpage )
                {
                    $(this).append("<li style='cursor:pointer;' onclick=callplugin("+totaldata+","+noofpage+","+data_per_page+","+pagelimit+",'"+url+"','"+divid+"','"+data+"');><a>Last<a></li>");
                }

            
        }

        
    });    
    
};

</script>
