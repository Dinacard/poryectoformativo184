@extends('layouts.app')

@section('titulo')
Compra Segura

@endsection

@section('css')
<style>
    /* Clear floats after the columnas */
    .fila:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive layout - makes the three columnas stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
        .columna {
            width: 100%;
            height: auto;
        }
    }

    @media all and (min-width: 992px) {
	.dropdown-menu li{ position: relative; 	}
	.nav-item .submenu{ 
		display: none;
		position: absolute;
		left:100%; top:-7px;
	}
	.nav-item .submenu-left{ 
		right:100%; left:auto;
	}
	.dropdown-menu > li:hover{ background-color: #f1f1f1 }
	.dropdown-menu > li:hover > .submenu{ display: block; }
}	
/* ============ desktop view .end// ============ */

/* ============ small devices ============ */
@media (max-width: 991px) {
  .dropdown-menu .dropdown-menu{
      margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
  }
}
</style>
<!-- Bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('content')
<!DOCTYPE html>
<html lang="en">

<nav class="navbar navbar-expand-lg  navbar-light bg-light">
<div class="container px-20 px-lg-20">
<div class="container-fluid">
<a class="navbar-brand" href="#">Compra Segura</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
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

    <li class="nav-item"><a class="nav-link" href="{{ Route ('historialpedidos') }}">Pedidos</a></li><li class="nav-item dropdown" id="myDropdown"> 
    
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
        <a class="btn btn-outline-dark" height="70px" type="button"
            width="70px" id="dropdown01" href="{{ Route ('existenteCarrito') }}">
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

    <header class="section page-header"></header> 
    <header class=" py-1">
    <div class="container px-4 px-lg-5 my-3">
    <div class="container px-4 px-lg-5">
    <img class="card-img-top" src="{{asset('img/tienda.png')}}" height="400px" alt="Card image cap"> 
        <div class="alert alert-primary text-center">
                @csrf
            <h1>MI PERFIL</H1>
            <div class="form-group text-left">
            <main>
    <div class="container">
  
      <div class="left box-primary">
        <img class="image" src="{{asset('img/perfil2.png')}}" alt="" />
       
        <h3 class="username text-center">{{auth()->user()->name}}</h3>
       
      </div>
      <div class="right tab-content">
    <form class="form-horizontal" method="post" action="{{ Route ('vp.actualizar')}}>
        @csrf
   
    <div class="mb-3>
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" value="{{auth()->user()->name }} ">
      <input type="hidden" name="id" class="form-control" value="{{auth()->user()->id }}">
    </div>

   
    <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="text" name="mail" class="form-control" value="{{auth()->user()->email}}">
        <input type="hidden" name="id" class="form-control" value="">
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" value="">
        <input type="hidden" name="id" class="form-control" value="{{auth()->user()->password }}">
    </div>
   
  
  </tbody>

</table>

<div>
<div class="btn-group btn-group-lg">
  <button class="btn btn-primary" type="submit">Guardar</button>
  <a class="btn btn-danger" href="{{ Route ('welcome')}}">Cancelar</a>
 </div>
   
</form>

      </div>
    </div>
  </main>
  </div>
<style>
      body{
  background-color: #ddd;
}
.container{
  margin: 0 auto;
  display: table;

}
.left{
  float: left;
  width: 214px;
  height: 366px;
}
.right{
  float: right;
  display: table;
  width: 60%;
}
.fa{
  display: inline-block;
}
.image{
  margin: 0 auto;
  width: 100px;
  height: 98px;
  border-radius: 50%;
  border: 1px solid gray;
  display: inline-block;
  padding: 3px;
  border: 3px solid #d2d6de;
  margin-top: 20px;
  margin-right: 57px;
  margin-left: 57px;

}
.has-feedback .form-control {
    padding-right: 42.5px;
}
select[multiple], select[size] {
    height: auto;
}
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
}
.form-control {
    display: block;
    width: 100%;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
}
label {
  cursor: default;
}
label {
  display: inline-block;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 700;
}
.usuername{
    font-size: 21px;
    margin-top: 5px;
}
.text-center {
    text-align: center;
}
.btn{
  margin: 0 auto;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;
  -webkit-user-select: none;
  touch-action: manipulation;
  margin-top: 100px;
}
a {
    color: #3c8dbc;
}
a {
    color: #337ab7;
    text-decoration: none;
}
.btn-primary {
    color: #fff;
    background-color: #337ab7;
    display: block;
}
h3{
    font-family: 'Source Sans Pro',sans-serif;
}

.control-label{
  float: left;
}
.form-horizontal .form-group {
    margin-right: -15px;
    margin-left: -15px;
}
.form-group {
    margin-bottom: 15px;
}

.btn-submit {
  background-color: #dd4b39;
  border-color: red;
}
.btn {
  border-radius: 3px;
  box-shadow: none;
  border: 1px solid transparent;
}

.has-feedback {
    position: relative;
}
.form-group {
    margin-bottom: 15px;
}
.left.box-primary {
    border-top-color: #3c8dbc;
    padding-top: 50px;
    
}
.left {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    padding: 10px;
}
button, meter, progress {
    -webkit-writing-mode: horizontal-tb;
}

    </style>          
</div>
                        



</form>
</div>
</div>
    
</html>
@endsection
@section('js')
<script>

document.addEventListener("DOMContentLoaded", function(){
// make it as accordion for smaller screens
if (window.innerWidth < 992) {

  // close all inner dropdowns when parent is closed
  document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
    everydropdown.addEventListener('hidden.bs.dropdown', function () {
      // after dropdown is hidden, then find all submenus
        this.querySelectorAll('.submenu').forEach(function(everysubmenu){
          // hide every submenu as well
          everysubmenu.style.display = 'none';
        });
    })
  });

  document.querySelectorAll('.dropdown-menu a').forEach(function(element){
    element.addEventListener('click', function (e) {
        let nextEl = this.nextElementSibling;
        if(nextEl && nextEl.classList.contains('submenu')) {	
          // prevent opening link if link needs to open dropdown
          e.preventDefault();
          if(nextEl.style.display == 'block'){
            nextEl.style.display = 'none';
          } else {
            nextEl.style.display = 'block';
          }

        }
    });
  })
}
// end if innerWidth
}); 
</script>
@stop
