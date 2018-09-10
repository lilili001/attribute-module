@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('attribute::attributes.edit attribute') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.attribute.attribute.index') }}">{{ trans('attribute::attributes.attributes') }}</a></li>
        <li class="active">{{ trans('attribute::attributes.edit attribute') }}</li>
    </ol>
@stop

@section('styles')
    <link href="{!! Module::asset('attribute:css/nestable.css') !!}" rel="stylesheet" type="text/css" />
    <style>
        .options {
            list-style: none;
        }
        .dd-item {
            margin-bottom: 10px;
        }
        .dd-handle {
            display: none;
        }
        .lang-group {
            display: inline;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.attribute.attribute.update', $attribute->id], 'method' => 'put','id'=>'inputForm' ]) !!}
    <div class="row">
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('attribute::admin.attributes.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form:: normalCheckbox('is_enabled', trans('attribute::attributes.is_enabled'), $errors, $attribute) !!}
                    {!! Form::normalCheckbox('has_translatable_values', trans('attribute::attributes.has_translatable_values'), $errors, $attribute) !!}
                    {!! Form::normalCheckbox('is_for_sku', trans('attribute::attributes.is_for_sku'), $errors, $attribute) !!}
                    {!! Form::normalCheckbox('is_for_sale', trans('attribute::attributes.is_for_sale'), $errors, $attribute) !!}
                    {!! Form::normalCheckbox('is_filterable', trans('attribute::attributes.is_filterable'), $errors,$attribute) !!}
                    {!! Form::normalCheckbox('is_visible_on_front', trans('attribute::attributes.is_visible_on_front'), $errors,$attribute )!!}
                    {!! Form::normalInput('key', trans('attribute::attributes.key'), $errors, $attribute) !!}

                    {!! Form::normalInput('position', trans('attribute::attributes.position'), $errors,$attribute) !!}

                    <div class="form-group">
                        {!! Form::label("attrset", 'attrset:') !!}
                        <select name="attrset_id" id="attrset" class="form-control">
                            <option value="">请选择</option>
                            <?php foreach ($attrsets as $set): ?>
                            <option value="{{ $set->id }}" {{ old('attrset_id',  !empty($curset) ? $curset->id : '' ) == $set->id ? 'selected' : '' }}>
                                {{ $set->name }}
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group {{ $errors->has('namespace') ? 'has-error' : '' }}">
                        {!! Form::label('namespace', trans('attribute::attributes.namespace')) !!}
                        {!! Form::select('namespace', $namespaces, old('namespace', $attribute->namespace), ['class' => 'selectize']) !!}
                        {!! $errors->first('namespace', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('attribute::attributes.configuration') }}</h3>
                </div>
                <div class="box-body">

                    @if( $attribute->key == 'size' )
                    <div class="row">
                        <size-header langs="{{json_encode(LaravelLocalization::getSupportedLocales())}}" size-header-form-values="{{$attribute->size_headers}}"></size-header>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                {!! Form::label('type', trans('attribute::attributes.type')) !!}
                                <select class="form-control jsTypeSelection" name="type" id="type">
                                    <option value="">{{ trans('attribute::attributes.select a type') }}</option>
                                    @foreach ($types as $type)
                                        <option data-allow-options="{{ $type->allowOptions() ?: 0 }}"
                                                {{ old('type', $attribute->type) === $type->getIdentifier() ? 'selected' : null }}
                                                value="{{ $type->getIdentifier() }}">{{  $type->getName() }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-8" style="margin-top: 22px">
                            @include('attribute::admin.attributes.partials.options_create')
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.attribute.attribute.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script src="{!! Module::asset('menu:js/jquery.nestable.js') !!}"></script>
    <script src="{!! Module::asset('attribute:js/attributes_form.js') !!}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.attribute.attribute.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $('button[type="submit"]').click(function(){
                $("#inputForm").validate({ ignore: [] });
            })


        });
    </script>
@stop
