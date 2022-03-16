@extends('layouts.app')

@section('titulo')
Compra Segura
@endsection

@section('content')

<nav class="navbar navbar-expand-lg  navbar-light bg-light">
  <div class="container px-20 px-lg-20">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Compra Segura</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <div class="container px-15 px-lg-15">
      <div class="collapse navbar-collapse " id="main_nav">
        <ul class="navbar-nav">
          <li class="nav-item active"> <a class="nav-link" href="{{ Route ('welcome') }}">Home </a> </li>
          <li class="nav-item"><a class="nav-link" href="{{ Route ('info') }}"> About </a></li>
          <li class="nav-item dropdown" id="myDropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categorias</a>
            <ul class="dropdown-menu">
              @foreach ($categorias as $ca)
              @if($ca->estado=="1")
              <li> <a class="dropdown-item" value="{{$ca->id_categoria}}">{{$ca->nombre_categoria}} &raquo; </a>
                @endif
                <ul class="submenu dropdown-menu">
                  @foreach ($subcategoria as $sub)
                  @if( $sub->id_categoria == $ca->id_categoria)
                  <li><a class="dropdown-item" href="{{ Route ('vProductos', $sub->id_subcategoria)}}">{{$sub->nombre_subcategoria}}</a></li>
                  @endif
                  @endforeach
                </ul>
              </li>
              @endforeach

            </ul>
          <li class="nav-item"><a class="nav-link" href="{{ Route ('vPerfil') }}">Mi Perfil</a></li>

          <li class="nav-item"><a class="nav-link" href="{{ Route ('historialpedidos') }}">Pedidos</a></li>
          <li class="nav-item dropdown" id="myDropdown">

          </li>
          <li class="nav-item dropdown" id="myDropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Ayuda</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ Route ('pecu') }}">PQRS</a></li>
              <li><a class="dropdown-item" href="{{ Route ('preguntas') }}">Preguntas frecuentes</a></li>
            </ul>
      </div>
      </li>

      <li class="nav dropdown">
        <a class="btn btn-outline-dark" height="70px" type="button" width="70px" id="dropdown01" href="{{ Route ('existenteCarrito') }}">
          <i class="bi-cart-fill me-1"></i>
          Carrito
          <span class="badge bg-dark text-white ms-1 rounded-pill">0</span></a>

      </li>

      </ul>

    </div>


  </div>
  <!-- navbar-collapse.// -->
  </div>
  <!-- container-fluid.// -->
  </div><!-- centrado.// -->
</nav>


<div id="info-table">
	<h1>Carrito de Compras</h1>
	<table id="mytable" width="1200" align="center">

		<div class="container px-4 px-lg-5">
			<div class="alert alert-primary text-center">

			</div>
		</div>
</div>
<tr>
	<th><input type="checkbox" id="allCheck" onclick="selectAll()" />SELECCIONAR TODO</th>
	<th>COMPRA SEGURA</th>
	<th>PRECIO C/U</th>
	<th>CANTIDAD</th>
	<th>SUBTOTAL</th>
	<th>TOTAL</th>
</tr>


@foreach($productos as $p)
<tr>
	<td>
		<input type="checkbox" class="selectOne" value="{{$p->id_pedido_x_producto}}" />
	</td>
	<td class="imgbackground"><img src="{{asset($p->imagen_producto)}}" height="100" width="100" /></td>

	<td class="integral">{{$p->valor_actual}}</td>
	<td>
		<button onclick="reduce(this,{{$p->id_pedido_x_producto}},{{$p->id_producto}})">-</button>
		<input type="text" readonly="true" value="{{$p->cantidad}}" />
		<button onclick="plus(this,{{$p->id_pedido_x_producto}},{{$p->id_producto}},{{$p->cantidad_existente}})">+</button>
	</td>
	<td id="s{{$p->id_pedido_x_producto}}">{{$p->valor_producto_venta}}</td>
	<td class="total">{{$pedidos->valor_total_factura}}</td>
	<td><a href="#" class="delete" onclick="deleteChild(this,{{$p->id_pedido_x_producto}})">Eliminar</a></td>
</tr>
@endforeach
<input type="hidden" id="pago">

</table>
</div>



<div id="info-input">
	<div class="total-div">
		<!--<span>PRECIO TOTAL:<span id="resultTotalMoney">0</span>PESO</span>-->
		<div id="paypal-button-container"></div>
	</div>
	<div class="btorinter-div">
		<button onclick="selectDelete()" class="btdelete">Eliminar seleccionado</button>
	</div>
</div>
</div>
<script>
			
			paypal.Buttons({
			onClick: function() {
				pago();
			},
			createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: document.getElementById('pago').value
                            }
                        }]
                    });
             },
			 onApprove: function(data,actions){
				actions.order.capture().then(function(detalles){
					console.log(detalles);
					pagado(detalles.id);
				});
			 },
			 onCancel:function(data){
				 alert("pago cancelado");
				 console.log(data);
			 }
			}).render('#paypal-button-container');

		function selectAll(){
			var obj = document.getElementsByClassName("selectOne");
			var btSelectAll = document.getElementById("allCheck").checked;
			for(inputCheck of obj){
				inputCheck.checked = btSelectAll;
			}
		}

		// eliminación única
		
		function deleteChild(obj,i){
			var nowtr = obj.parentElement.parentElement;
			var nowtable = nowtr.parentElement;
			console.log (nowtr);
			nowtable.removeChild(nowtr);
			$.ajax({
				type: "post",
				url: "{{ Route ('cart.eliminar')}}",
				data: {
					id: i,
					idPedido:{{$pedidos->id_pedidos}},
					_token: '{{ csrf_token() }}'
				},
				// dataType: 'json',
				success: function(res) {
					const demoClasses = document.querySelectorAll('.total');

                     // Change the text of multiple elements with a loop
                    demoClasses.forEach(element => {
                    element.textContent = res;
                    });
					var pagoUSD = (res / 3819);
                    pagoUSD = Math.round((pagoUSD + Number.EPSILON) * 100) / 100;
                    console.log(pagoUSD)
			        document.getElementById('pago').value = pagoUSD;


				},
				error: function(error) {
					console.log(error);
				}

			});
		}
		// eliminación por lotes
		function selectDelete(){
			var obj = document.getElementsByClassName("selectOne");
			for (var i = obj.length - 1;i >= 0;i--){
				var nowCheck = obj[i];
				if (nowCheck.checked == true){
		
					deleteChild(nowCheck,nowCheck.value);
				}
			}
		}
		
		// reducir en cantidad
		function reduce(obj,i,pro){
			var textElement = obj.parentElement.children[1];
			if (textElement.value == "1"){
				return;
			}
			textElement.value = eval(textElement.value + "-1");
			$.ajax({
				type: "post",
				url: "{{ Route ('cart.reducir')}}",
				data: {
					id: i,
					idP: pro,
					idPedido:{{$pedidos->id_pedidos}},
					_token: '{{ csrf_token() }}'
				},
				// dataType: 'json',
				success: function(res) {
					var sub = ""+"#s"+ i + ""
					document.querySelector(sub).innerHTML = res[1];
					const demoClasses = document.querySelectorAll('.total');

                     // Change the text of multiple elements with a loop
                    demoClasses.forEach(element => {
                    element.textContent = res[0];
                    });
					var pagoUSD = (res[0] / 3819);
                    pagoUSD = Math.round((pagoUSD + Number.EPSILON) * 100) / 100;
                    console.log(pagoUSD)
			        document.getElementById('pago').value = pagoUSD;

				},
				error: function(error) {
					console.log(error);
				}

			});
		}
		// Incrementa el número de
		function plus(obj,i,pro,cant){
			var textElement = obj.parentElement.children[1];
			if (textElement.value == cant){
				return;
			}
			textElement.value = eval(textElement.value + "+1");
			$.ajax({
				type: "post",
				url: "{{ Route ('cart.incrementar')}}",
				data: {
					id: i,
					idP: pro,
					idPedido:{{$pedidos->id_pedidos}},
					_token: '{{ csrf_token() }}'
				},
				// dataType: 'json',
				success: function(res) {
					var sub = ""+"#s"+ i + ""
					document.querySelector(sub).innerHTML = res[1];
					const demoClasses = document.querySelectorAll('.total');

                     // Change the text of multiple elements with a loop
                    demoClasses.forEach(element => {
                    element.textContent = res[0];
                    });
					var pagoUSD = (res[0] / 3819);
                    pagoUSD = Math.round((pagoUSD + Number.EPSILON) * 100) / 100;
                    console.log(pagoUSD)
			        document.getElementById('pago').value = pagoUSD;

				},
				error: function(error) {
					console.log(error);
				}

			});
		}
		// Inicializar el valor a pagar
		window.onload = function totalPago()
		{
			var pagoCOP = {{$pedidos->valor_total_factura}};
			var pagoUSD = (pagoCOP / 3819);
            pagoUSD = Math.round((pagoUSD + Number.EPSILON) * 100) / 100;
            console.log(pagoUSD)
			document.getElementById('pago').value = pagoUSD;
		}
		// verificar si existe una cantidad de paga
		function pago(){
				var pago = document.getElementById('pago').value
				if (pago == 0) {
					alert("no tienes pedidos en carrito");
					location.href = "{{route('welcome')}}";
				}
			}

		function pagado(numFac){
			$.ajax({
				type: "post",
				url: "{{ Route ('cart.pagado')}}",
				data: {
					fac:numFac,
					_token: '{{ csrf_token() }}'
				},
				// dataType: 'json',
				success: function(res) {
					alert ("listo");
				},
				error: function(error) {
					console.log(error);
				}
		    });
		}
	</script>
@endsection

@section('css')
<style>
	#info-table {
		text-align: center;
	}

	#info-input {
		width: 1200px;
		margin: 0px auto;
	}

	#info-input>div {
		width: 1200px;
		margin: 20px 0px;
	}

	.shopCount {
		color: orange;
	}

	a {
		text-decoration: none;
		color: deepskyblue;
	}

	#resultTotalMoney,
	#integralTotal {
		color: orange;
	}

	.total-div {
		text-align: right;
	}

	.btdelete {
		float: left;
	}

	.btorinter-div {
		height: auto;
		overflow: auto;
	}

	.viewIntegral {
		float: right;
	}

	.btbuy {
		background-color: orange;
		color: white;
		border: 0px;
		float: right;
	}

	#shop {
		width: 800px;
		margin: 0px auto;
		height: auto;
		overflow: auto;
	}

	#shop li {
		text-align: center;
		list-style: none;
		float: left;
		height: auto;
		overflow: auto;
		margin: 20px;
	}

	#shop a {
		display: block;
		height: auto;
		overflow: auto;
	}

	.price {
		color: red;
	}
</style>
@endsection

@section('js')

@stop