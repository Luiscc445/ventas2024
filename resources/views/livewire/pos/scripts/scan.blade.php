<script>
    try {

        onScan.attachTo(document, {
            suffixKeyCodes: [13],
            onScan: function(barcode) {
                window.livewire.emit('san-code', barcode)
            },
            onScanError: function(e) {
                console.log(e)
            }
        })

        console.log('El scanner ready!')

    } catch (error) {

        console.log('Error de lectura: ', error)
        
    }
</script>