<script>
    $(document).ready(function(){
        $('.changeLang').on('click', function(){

            var lang = $(this).data('lang');
            $.ajax({
                type: 'post',
                url: '/index/setLang',
                data: {lang : lang},
                success: function(){
                    location.reload();
                }
            })
        });
    });
</script>

<footer>
    <a class="changeLang" data-lang="en" href="#">English</a>&nbsp;&nbsp;&nbsp;<a class="changeLang" data-lang="ru" href="#">Руский</a>
</footer>