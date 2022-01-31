<script>
    $(function () {
        $('#province').on('change', function () {
            $('#district').empty();
            $('#district').append('<option value="" selected disabled>Loading...</option>')
            $.ajax({
                url: "{{ route('region')}}",
                method: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'code': $(this).val(),
                    'type': 'district'
                },
                success: function (response) {
                    $('#village').empty();
                    $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                    $('#sub-district').empty();
                    $('#sub-district').append('<option value="" selected disabled>Pilih Kecamatan</option>')
                    $('#district').empty();
                    $('#district').append('<option value="" selected disabled>Pilih Kabupaten/Kota</option>')
                    $.each(response, function (id, object) {
                        $('#district').append(new Option(object.name, object.code))
                    })
                }
            })
        });
        $('#district').on('change', function () {
            $('#sub-district').empty();
            $('#sub-district').append('<option value="" selected disabled>Loading...</option>')
            $.ajax({
                url: "{{ route('region')}}",
                method: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'code': $(this).val(),
                    'type': 'sub-district'
                },
                success: function (response) {
                    $('#village').empty();
                    $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                    $('#sub-district').empty();
                    $('#sub-district').append('<option value="" selected disabled>Pilih Kecamatan</option>')
                    $.each(response, function (id, object) {
                        $('#sub-district').append(new Option(object.name, object.code))
                    })
                }
            })
        });
        $('#sub-district').on('change', function () {
            $('#village').empty();
            $('#village').append('<option value="" selected disabled>Loading...</option>')
            $.ajax({
                url: "{{ route('region')}}",
                method: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'code': $(this).val(),
                    'type': 'village'
                },
                success: function (response) {
                    $('#village').empty();
                    $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                    $.each(response, function (id, object) {
                        $('#village').append(new Option(object.name, object.code))
                    })
                }
            })
        });
    });

</script>