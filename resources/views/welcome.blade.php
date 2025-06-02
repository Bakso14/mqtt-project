<!DOCTYPE html>
<html>
<head>
    <title>Form Kirim MQTT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Form Kirim Pesan MQTT</h2>

    <form id="mqttForm">
        <label>Broker:</label><br>
        <input type="text" name="broker" value="broker.hivemq.com"><br><br>

        <label>Port:</label><br>
        <input type="number" name="port" value="1883"><br><br>

        <label>Topik:</label><br>
        <input type="text" name="topic" value="laravel/demo"><br><br>

        <label>Pesan:</label><br>
        <textarea name="message">Halo dari Laravel!</textarea><br><br>

        <button type="submit">Kirim MQTT</button>
    </form>

    <p id="status"></p>

    <script>
        document.getElementById('mqttForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => data[key] = value);

            fetch('{{ route('kirim.mqtt') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                document.getElementById('status').innerText = result.status;
            })
            .catch(error => {
                document.getElementById('status').innerText = 'Gagal: ' + error;
            });
        });
    </script>
</body>
</html>
