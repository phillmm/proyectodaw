document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#btn-pass');
    button.addEventListener('click', newPass);
});

function newPass() {
    const profile = document.querySelector('#profile')

    const form = document.createElement('form')
    form.classList.add('password')
    form.setAttribute('method', 'POST')

    const tit = document.createElement('h3')
    tit.innerHTML = 'Actualizar Contraseña'

    const div1 = document.createElement('DIV')
    const div2 = document.createElement('DIV')

    div1.classList.add('password__campo')
    div2.classList.add('password__campo')

    const lbl1 = document.createElement('LABEL')
    lbl1.textContent = 'Nueva contraseña'

    const lbl2 = document.createElement('LABEL')
    lbl2.textContent = 'Repite la contraseña'

    const hiddenInput = document.createElement('INPUT')
    hiddenInput.setAttribute('type', 'hidden')
    hiddenInput.setAttribute('name', 'new_pass')
    hiddenInput.setAttribute('id', 'new_pass')
    hiddenInput.setAttribute('value', '1')

    form.appendChild(hiddenInput)

    const inp1 = document.createElement('INPUT')
    inp1.setAttribute('type', 'password')
    inp1.setAttribute('name', 'pass')
    inp1.setAttribute('id', 'pass')
    inp1.setAttribute('placeholder', 'Nueva contraseña')

    div1.appendChild(lbl1)
    div1.appendChild(inp1)

    const inp2 = document.createElement('INPUT')
    inp2.setAttribute('type', 'password')
    inp2.setAttribute('name', 'pass2')
    inp2.setAttribute('id', 'pass2')
    inp2.setAttribute('placeholder', 'Repite la contraseña')

    const submitBtn = document.createElement('INPUT')
    submitBtn.setAttribute('type', 'submit')
    submitBtn.setAttribute('value', 'Actualizar')
    submitBtn.classList.add('boton-verde')

    const cancelar = document.createElement('A')
    cancelar.textContent = 'Cancelar'
    cancelar.href = '/perfil'
    
    div2.appendChild(lbl2)
    div2.appendChild(inp2)
    
    form.appendChild(tit)
    form.appendChild(div1)
    form.appendChild(div2)
    form.appendChild(submitBtn)
    form.appendChild(cancelar)

    profile.appendChild(form)
}