@extends('app')

@section('title')
Subscribe
@stop

@section('content')

<h1>Demo PHPSP + IMA</h1>
<hr>

<div class="container">
    <div class="col-md-6 col-md-offset-3 text-center">
        <h3>
            Não perca essa oportunidade. 
        </h3>
        <p>
            Cadastre-se e ganhe nosso exclusivo muito obrigado !!!    
        </p>
        <p> 
            <strong>{{ $qtdeSubscribed }} felizardo(s)</strong> 
        </p>
        <p>já ganhou(aram) nosso muito obrigado.</p>
    </div>
</div>
<div class="container">
    <hr>
</div>
{!! Form::open() !!}
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        
        <div class="form-group">
            {!! Form::label('email', 'Cadastre-se você também:') !!}    
            {!! Form::text('email', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Cadastrar',['class'=>'btn btn-primary form-control']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop

