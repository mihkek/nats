<table class="ticketit-table table table-striped table-bordered dt-responsive" style="width:100%">
    <thead>
        <tr>
            <td>{{ trans('ticketit::lang.table-id') }}</td>
            <td>{{ trans('ticketit::lang.table-subject') }}</td>
            <td>{{ trans('ticketit::lang.table-status') }}</td>
            <td>{{ trans('ticketit::lang.table-last-updated') }}</td>
            <td>{{ trans('ticketit::lang.table-agent') }}</td>
          @if( $u->isAgent() || $u->isAdmin() )
            <td>{{ trans('ticketit::lang.table-priority') }}</td>
            <td>{{ trans('ticketit::lang.table-owner') }}</td>
            <td>{{ trans('ticketit::lang.table-category') }}</td>
          @endif
        </tr>
    </thead>
    <tbody id="table">
        
    </tbody>
</table>
@push('scripts')
<script>
    jQuery(document).ready(function() {
        let url = window.location.pathname.split('/')
        $.ajax({
            headers: {  
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            url: '/admin/get_tickets',
            data: {status: url[url.length-1]},
            success: function(result){
                $('#table').html(result.str)
            }
        });  
        let interval = setInterval(function() {
            let url = window.location.pathname.split('/')
            $.ajax({
                headers: {  
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                url: '/admin/get_tickets',
                data: {status: url[url.length-1]},
                success: function(result){
                    $('#table').html(result.str)
                }
            });  
        }, 60000);
    });
</script>
@endpush
