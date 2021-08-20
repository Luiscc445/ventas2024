<script>
    $('.tblscroll').niceScroll({
        cursorcolor:"3515365",
        cursorwidth:"24px",
        background:"rgba(20,20,20,0.3)",
        cursorborder:"0px",
        cursorborderradius:3
    })

    function Confirm(id, eventName, text)
    {
    
        Swal.fire({
            title: 'Confirmar',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B3F5C',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.value) {
                window.livewire.emit(eventName, id)
                Swal.clse()
            }
        })
    };
</script>