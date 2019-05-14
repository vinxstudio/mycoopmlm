@extends('layouts.master')
@section('content')

    @if ($type == 'universal' and Request::segment(4) > 0)
        <div class="alert alert-danger">
            <p>{{ Lang::get('products.universal_warning') }}</p>
        </div>
    @endif

    @include('Admin.Products.views.unilevel_form')

    <table class="table table-bordered table-stripe">
        <thead>
        <tr>
            <th>{{ Lang::get('products.level') }}</th>
            <th>{{ Lang::get('products.amount') }}</th>
            <th>{{ Lang::get('labels.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @if ($settings->isEmpty())
            <tr>
                <td colspan="4">
                    <center>
                        <i>{{ Lang::get('products.no_unilevel') }}</i>
                    </center>
                </td>
            </tr>
        @else
            @foreach ($settings as $row)
                {{ Form::open() }}
                <tr>
                    <td>{{ $row->level }} @if ($row->product_id > 0) {{ $row->product->name }} @endif</td>
                    <td>{{ Form::text(sprintf('amount[%s]', $row->id), old(sprintf('amount[%s]', $row->id), $row->amount), [
                        'class'=>'form-control'
                    ]) }}</td>
                    <td>
                        {{ Form::hidden(sprintf('level[%s]', $row->id), old(sprintf('level[%s]', $row->id), $row->level)) }}
                        {{ Form::hidden(sprintf('product_id[%s]', $row->id), old(sprintf('product_id[%s]', $row->id), $row->product_id)) }}
                        {{ Form::hidden('id', $row->id) }}
                        {{ Form::button(Lang::get('labels.update'), [
                            'name'=>'update',
                            'value'=>'update',
                            'class'=>'btn btn-primary btn-xs',
                            'type'=>'submit'
                        ]) }}
                    </td>
                </tr>
                {{ Form::close() }}
            @endforeach
        @endif
        </tbody>
    </table>
@stop

@section('custom_includes')
    <script type="text/javascript">
        $(function(){

            $('#unilevel_type').change(function(){

                var selected = $(this).children('option:selected').val();

                if (selected == 'per_product'){
                    $('#product_list').removeClass('hidden');
                } else {
                    $('#product_list').addClass('hidden');
                }

            }).trigger('change');

            $('#product').change(function(){

                var selected = $(this).children('option:selected').val();

                if (selected != ''){
                    location.href = "<?php echo url('admin/products/unilevel') ?>/"+selected;
                }

            });

        });
    </script>
@stop