<script>

    document.addEventListener('DOMContentLoaded', function(){

        window.livweire,on('scan-ok', msg => {
            noty(msg)
        })

        window.livweire,on('scan-notfound', msg => {
            noty(msg, 2)
        })

        window.livweire,on('no-stock', msg => {
            noty(msg, 2)
        })

        window.livweire,on('sale-error', msg => {
            noty(msg)
        })

        window.livweire,on('sale-ok', msg => {
            noty(msg)
        })

        window.livweire,on('print-ticket', saleId => {
            window.open("print://" + saleId, '_black')
        })

    })

</script>