

jQuery.fn.jquery_validation  = function(component, classname)
{
    $(component+' .'+classname+' .errors').remove();
    var check_list = {};    
    check_list.regx_name = /^[A-Za-z\s.]+$/;
    check_list.regx_general = /^[A-Za-z0-9\s.\-\/]{2,30}$/;
    check_list.regx_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    check_list.regx_digit =/^[0-9]+$/;
    check_list.regx_mobileno = /^((0091)|(\+91)|0?)[789]{1}\d{9}$/;
    check_list.regx_mark = /^[+]?[0-9]+(\.[0-9]+)?$/; 
    check_list.regx_rupees = /^[1-9]\d*(((,\d{3}){1})?(\.\d{1,2})?)$/;
    check_list.regx_signed_rupees = /^[+-]?[1-9]\d*(((,\d{3}){1})?(\.\d{1,2})?)$/;
    check_list.regx_percentage = /(^100([.]0{1,3})?)$|(^\d{1,2}([.]\d{1,3})?)$/;
    check_list.regx_username = /^[a-z0-9_-]{3,16}$/;
    check_list.regx_password = /^[a-z0-9_-]{6,18}$/;
    check_list.regx_comma_separated = /^[A-Za-z0-9\s.\-\:\,/]{6,250}$/;
    check_list.regx_rupees = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,2})?)$/;
    check_list.regx_unsigned_floatno = /^(?:\d*\.\d{1,4}|\d+)$/;     
    check_list.regx_unsigned_floatno_max2_2 = /^(?:\d{1,2}\.\d{1,2}|\d+)$/;    
    check_list.regx_date_asc = /^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/;
    check_list.regx_date_desc = /^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/;
    check_list.regx_comma_numbers = /^(([1-9]+)(,(?=[1-9]))?)+$/;    
    var error_flag = 0;
    
    $(component+' .'+classname+' .required').each(function(index, element)
    {
        var elem = $(this);
        var data = $.trim(this.value);  
        $.each($(this).attr('class').split(/\s+/), function(i, v)
        {
            if(check_list[v] != undefined )
            {
                if(!(check_list[v]).test(data))
                {
                    elem.after("<span class='errors' style='margin: 0 10px; font-style: italic; font-size: 14px; color:red;'>Invalid Entry</div>");
                    error_flag = 1;
                }
            }           
        });
    }); 
    
    return error_flag;   
};


