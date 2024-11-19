function advertencia(e){
	e.preventDefault();
	var url=e.currentTarget.getAttribute("href");
	Swal.fire({
		title: '¿Está seguro de eliminar a este usuario?',
		text: '¡No podrás deshacerlo!',
		icon: 'warning',	/*icono que va mostrar success-error-info-warning-question*/
		showCancelButton: true,
		confirmButtonColor: '#2CB073',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar',
		cancelButtonText: 'No, Salir',
		reverseButtons: true,
		//width:'300px',
		padding: '20px',
		//background: 'rgb(70,200,255)',
		backdrop: true,	/* color oscuro de la pagina true-false */

		position: 'top',	/* posicion de ubicacion top--bottom--center top-end bottom-end top-start */
		/* bottom-start center-start center-end */

		allowOutsideClick: true,	/* para NO salir con un click */
		allowEscapeKey: true,	/* para SI salir con un escape */
		allowEnterKey: false,	/* para SI salir con un enter */

	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
		  //this.submit();
		  window.location.href=url;
		}
	})
}

function advertenciaCat(e){
	e.preventDefault();
	var url=e.currentTarget.getAttribute("href");
	Swal.fire({
		title: '¿Está seguro de eliminarlo?',
		text: '¡Se perderan todos los registros relacionados a este elemento!',
		icon: 'warning',	/*icono que va mostrar success-error-info-warning-question*/
		showCancelButton: true,
		confirmButtonColor: '#2CB073',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar',
		cancelButtonText: 'No, Salir',
		reverseButtons: true,
		//width:'300px',
		padding: '20px',
		//background: 'rgb(70,200,255)',
		backdrop: true,	/* color oscuro de la pagina true-false */

		position: 'top',	/* posicion de ubicacion top--bottom--center top-end bottom-end top-start */
		/* bottom-start center-start center-end */

		allowOutsideClick: true,	/* para NO salir con un click */
		allowEscapeKey: true,	/* para SI salir con un escape */
		allowEnterKey: false,	/* para SI salir con un enter */

	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
		  //this.submit();
		  window.location.href=url;
		}
	})
}

function confirmacionVolverAdmin(e){
	e.preventDefault();
	var url=e.currentTarget.getAttribute("href");
	Swal.fire({
		title: '¿Está seguro que quieres volver a este usuario administrador?',
		text: '¡ No podras deshacerlo !',
		icon: 'warning',	/*icono que va mostrar success-error-info-warning-question*/
		showCancelButton: true,
		confirmButtonColor: '#2CB073',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar',
		cancelButtonText: 'No, Salir',
		reverseButtons: true,
		//width:'300px',
		padding: '20px',
		//background: 'rgb(70,200,255)',
		backdrop: true,	/* color oscuro de la pagina true-false */

		position: 'top',	/* posicion de ubicacion top--bottom--center top-end bottom-end top-start */
		/* bottom-start center-start center-end */

		allowOutsideClick: true,	/* para NO salir con un click */
		allowEscapeKey: true,	/* para SI salir con un escape */
		allowEnterKey: false,	/* para SI salir con un enter */

	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
		  //this.submit();
		  window.location.href=url;
		}
	})
}

function confirmacionEliminar(e){
	e.preventDefault();
	var url=e.currentTarget.getAttribute("href");
	Swal.fire({
		title: '¿Está seguro que deseas eliminar este habito?',
		text: '¡Perderas todo tu progreso!',
		icon: 'warning',	/*icono que va mostrar success-error-info-warning-question*/
		showCancelButton: true,
		confirmButtonColor: '#2CB073',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar',
		cancelButtonText: 'No, Salir',
		reverseButtons: true,
		//width:'300px',
		padding: '20px',
		//background: 'rgb(70,200,255)',
		backdrop: true,	/* color oscuro de la pagina true-false */

		position: 'top',	/* posicion de ubicacion top--bottom--center top-end bottom-end top-start */
		/* bottom-start center-start center-end */

		allowOutsideClick: true,	/* para NO salir con un click */
		allowEscapeKey: true,	/* para SI salir con un escape */
		allowEnterKey: false,	/* para SI salir con un enter */

	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
		  //this.submit();
		  window.location.href=url;
		}
	})
}