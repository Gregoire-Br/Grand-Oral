function alert(message, type) {
  var alertPlaceholder = document.getElementById('alertPlaceholder')

  var wrapper = document.createElement('div')
  wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

  alertPlaceholder.appendChild(wrapper)
}