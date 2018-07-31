var login = {
    init: function(){
        this.login();
    },
    bindEvent: function(){
        $(".w_heiht").height($(window).height());
    },
    logindo:function(err, data) {
    	if(err){
            alert(err);

        }else{
            location='/';
        }
    },
    login: function(){
        $(".login_btn1").on('click', function(){
            if($(".login_name").val() ==""){
                $(".login_name").siblings('.error').show();
                return ;
            }else if($(".login_password").val() ==""){
                $(".login_password").siblings('.error').show();
                return ;
            }
            var data	= [],
            $this		= $(this),
            self		= this,            
            call		= login.logindo;
	        
	        $.ajax({
	            url:$this.attr('action'),
	            async:true,
	            data:{username:$(".login_name").val(),password:$(".login_password").val()},
	            type:$this.attr('method')||'get',
	            dataType:'json',
	            headers:{"x-form-call":1},
	            error:function(xhr, textStatus, errThrow){
	            	var errorMessage=xhr.getResponseHeader('X-Error-Message');
	                call.call(self, decodeURIComponent(errorMessage), data);
	            },
	            success:function(data, textStatus, xhr, headers){
	                var errorMessage=xhr.getResponseHeader('X-Error-Message');
	                if(errorMessage){
	                    call.call(self, decodeURIComponent(errorMessage), data);
	                }else{
	                    call.call(self, null, data);
	                }
	            }
	        });
 
           
        })
    }
    
}
login.init();