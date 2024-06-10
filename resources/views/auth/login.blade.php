<x-login-layout>
    <div id="login">
        <div class="login">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>Iniciar Sesión</h3>
                    </div>
                    <div class="card-body">
                        <form id="formLogin">
							<div for="email"></div>
                            <div class="input-group form-group">
							
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>								
                                <input type="text" id="email" id="email" name="email" class="form-control" placeholder="username" >
                            </div>
							<div for="password"></div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="password">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Ingresar" class="btn float-right login_btn">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            <a href="#">Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            
            var register = new Vue({
                el: '#login',
                data: {
                },
                filters: {},
                beforeMount: function() {                    
                },
                mounted: function() {   
					validations();
						//alert("hola");
                },
                computed: {
                },
                watch: {                   
                },
                methods: {
                }
            });
            

			function validations(){

				jQuery.validator.addMethod("password", function (value, element) {
                    var result = this.optional(element) || value.length >= 8 && /\d/.test(value) && /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@\[-`{-~]).{8,64}$/i.test(value);

                    // Mostrar u ocultar el popover en función de la validación
                    if(!result){
                        //$("#password-info-link").tooltip('show');
                    	var validator = this;                    

                    }else{
                        $("#password-info-link").tooltip('hide');
                    }
                    

                    return result;
                }, 'Formato de Password incorrecto');

				jQuery.validator.addMethod("formatEmail", function(value, element) {
                return this.optional( element ) || /^[a-zA-Z0-9.!#$%&*+=_]+@(?:\S{1,63})$/.test( value );
                }, 'only: "!#$%&*+=_" are accepted.');

				var form = $("#formLogin").show();
                form.validate({
                    errorClass: "field-invalid-rx",
                    errorElement: "span",
                    errorPlacement: function(error, element) {
                        error.appendTo($('div[for=' + element.attr("name") + ']'));
                    },
                    rules: {
                        email:{
                            email: true,
                            required:true,
                            formatEmail:true
                        },
                        passwordLogin: {
                            minlength: 8,
                            required:true,
                        }, 
                        
                    },
                    messages: {
                        email: {
                            email: 'Formato de correo invalido',
                            required: 'Email requerido',
                            formatEmail:'Formato de correo invalido'
                        },
                        passwordLogin: {
                            minlength: '{{ __("rxcard.general.validate-format-password") }}',
                            required: '{{ __("rxcard.general.required") }}'
                        },
                    }
                });
			}
        </script>
    @endpush
</x-login-layout>
