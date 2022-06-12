<footer class="main-footer shadow-sm text-center text-sm-left"><strong>{{ config('app.name') }} &copy;
            {{ date('Y', time()) }}
      </strong>
      <div class="text-center my-2 my-sm-0 float-sm-right d-block d-sm-inline-block">
            <div class="btn btn-sm btn-secondary font-weight-bold">
                  <i class="fas fa-clock"></i>
                  <span id="time-footer">{{ date('d/m/Y H:i:s', time()) }}</span>
            </div>
      </div>
</footer>

@push('scripts')
<script type="text/javascript">
      window.setTimeout("timerFooter()", 1000);
    function timerFooter() {
        var date = new Date();
        setTimeout("timerFooter()",1000);
        document.getElementById("time-footer").innerHTML = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear() + ' ' + ('0' + date.getHours()).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2) + ':' + ('0' + date.getSeconds()).slice(-2);
    }
</script>
@endpush