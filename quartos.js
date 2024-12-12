
   
        const modal = document.getElementById('modal');
        const btnAdicionar = document.getElementById('btn-adicionar');
        const closeBtn = document.querySelector('.close');
        const form = document.getElementById('form-quarto');

        const botoesEditar = document.querySelectorAll('.btn-editar');
        const botoesExcluir = document.querySelectorAll('.btn-excluir');

      
        btnAdicionar.addEventListener('click', () => {
            document.getElementById('input-id').value = '';
            document.getElementById('input-numero').value = '';
            document.getElementById('input-status').value = 'liberado';
            document.getElementById('input-tipo').value = 'comum';
            document.getElementById('input-dias').value = '0';
            document.getElementById('input-preco').value = '';
            
            document.getElementById('input-action').value = 'adicionar';
            modal.style.display = 'block';
        });

     
        botoesEditar.forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.getElementById('input-id').value = e.target.getAttribute('data-id');
                document.getElementById('input-numero').value = e.target.getAttribute('data-numero');
                document.getElementById('input-status').value = e.target.getAttribute('data-status');
                document.getElementById('input-tipo').value = e.target.getAttribute('data-tipo');
                document.getElementById('input-dias').value = e.target.getAttribute('data-dias');
                document.getElementById('input-preco').value = e.target.getAttribute('data-preco');
                
                document.getElementById('input-action').value = 'editar';
                modal.style.display = 'block';
            });
        });

       
        botoesExcluir.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.target.getAttribute('data-id');
                
                const form = document.createElement('form');
                form.method = 'POST';
                
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;
                
                const inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'action';
                inputAction.value = 'excluir';
                
                form.appendChild(inputId);
                form.appendChild(inputAction);
                
                document.body.appendChild(form);
                form.submit();
            });
        });

      
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

    
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
   