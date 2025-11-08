<div class="row padding-1 p-1">
    <div class="col-md-12">

        <select name="questionnaire_id" id="questionnaire_id" class="form-control @error('questionnaire_id') is-invalid @enderror">
            <option value="">{{ __('Seleccione un cuestionario') }}</option>
            @foreach($questionnaires as $q)
                <option value="{{ $q->id }}" {{ old('questionnaire_id', $questionnaireItem->questionnaire_id) == $q->id ? 'selected' : '' }}>
                    {{ $q->code }} (ID: {{ $q->id }})
                </option>
            @endforeach
        </select>

        <div id="items-container"></div>

        <div class="mt-3">
            <button type="button" id="add-item" class="btn btn-success">{{ __('Agregar Pregunta') }}</button>
        </div>

    </div>

    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Guardar Cuestionario') }}</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('items-container');
    const addItemBtn = document.getElementById('add-item');

    function createItem(index, existingItem = null) {
        const div = document.createElement('div');
        div.classList.add('card', 'p-3', 'mb-3');

        const itemId = existingItem?.id || '';
        div.dataset.itemId = itemId;
        div.dataset.currentOrder = existingItem?.item_order || index + 1;

        let choicesHtml = '';
        if(existingItem && ['likert','opcion'].includes(existingItem.response_type)) {
            choicesHtml = `<div class="choices-container mb-2">`;
            existingItem.choices.forEach((choice, cIndex) => {
                choicesHtml += `
                    <div class="choice-item d-flex gap-2 mb-2">
                        <input type="text" name="items[${index}][choices][${cIndex}][label]" class="form-control choice-label" value="${choice.label}">
                        <input type="text" name="items[${index}][choices][${cIndex}][value]" class="form-control choice-value" value="${choice.value}">
                        ${choice.id ? `<input type="hidden" name="items[${index}][choices][${cIndex}][id]" value="${choice.id}">` : ''}
                        <button type="button" class="btn btn-danger btn-sm remove-choice">Eliminar</button>
                    </div>
                `;
            });
            choicesHtml += `</div><button type="button" class="btn btn-success btn-sm add-choice">Agregar opción</button>`;
        }

        // Si es numero, renderizar con min y max
        if(existingItem && existingItem.response_type === 'numero') {
            choicesHtml = `
                <input type="number" 
                       name="items[${index}][meta][min]" 
                       placeholder="Mínimo" 
                       class="form-control mb-1"
                       value="${existingItem?.meta?.min ?? ''}">
                <input type="number" 
                       name="items[${index}][meta][max]" 
                       placeholder="Máximo" 
                       class="form-control"
                       value="${existingItem?.meta?.max ?? ''}">
            `;
        }

        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Pregunta ${index + 1}</strong>
                <button type="button" class="btn btn-danger btn-sm remove-item">Eliminar</button>
            </div>
            <div class="mb-2">
                <label>Texto de la Pregunta</label>
                <input type="text" name="items[${index}][question_text]" class="form-control" value="${existingItem?.question_text || ''}" required>
            </div>
            <div class="mb-2">
                <label>Tipo de Respuesta</label>
                <select name="items[${index}][response_type]" class="form-control response-type">
                    <option value="likert" ${existingItem?.response_type=='likert'?'selected':''}>Likert</option>
                    <option value="booleano" ${existingItem?.response_type=='booleano'?'selected':''}>Booleano</option>
                    <option value="numero" ${existingItem?.response_type=='numero'?'selected':''}>Número</option>
                    <option value="texto" ${existingItem?.response_type=='texto'?'selected':''}>Texto</option>
                    <option value="opcion" ${existingItem?.response_type=='opcion'?'selected':''}>Opción</option>
                </select>
            </div>
            <div class="dynamic-options mt-2">${choicesHtml}</div>
            <input type="hidden" name="items[${index}][item_order]" value="${existingItem?.item_order || index + 1}">
        `;

        container.appendChild(div);
        addRemoveHandlers();
        addResponseTypeHandler(div);

        if(existingItem && ['likert','opcion'].includes(existingItem.response_type)) {
            setupChoices(div.querySelector('.dynamic-options'));
        }
    }

    function addRemoveHandlers() {
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.onclick = function () {
                this.closest('.card').remove();
                updateIndexes();
            };
        });
    }

    function addResponseTypeHandler(itemDiv) {
        const select = itemDiv.querySelector('.response-type');
        const optionsContainer = itemDiv.querySelector('.dynamic-options');

        function renderOptions() {
            const type = select.value;
            const card = itemDiv.closest('.card');
            const itemIdx = Array.from(container.children).indexOf(card);

            if(['likert', 'opcion'].includes(type)) {
                optionsContainer.innerHTML = `
                    <div class="choices-container mb-2">
                        <div class="choice-item d-flex gap-2 mb-2">
                            <input type="text" name="items[${itemIdx}][choices][0][label]" placeholder="Etiqueta" class="form-control choice-label">
                            <input type="text" name="items[${itemIdx}][choices][0][value]" placeholder="Valor" class="form-control choice-value">
                            <button type="button" class="btn btn-danger btn-sm remove-choice">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm add-choice">Agregar opción</button>
                `;
                setupChoices(optionsContainer);
            } else if(type === 'numero') {
                optionsContainer.innerHTML = `
                    <input type="number" 
                           name="items[${itemIdx}][meta][min]" 
                           placeholder="Mínimo" 
                           class="form-control mb-1">
                    <input type="number" 
                           name="items[${itemIdx}][meta][max]" 
                           placeholder="Máximo" 
                           class="form-control">
                `;
            } else {
                optionsContainer.innerHTML = '';
            }
        }

        select.addEventListener('change', renderOptions);
    }

    function setupChoices(optionsContainer) {
        const addBtn = optionsContainer.querySelector('.add-choice');
        const choicesContainer = optionsContainer.querySelector('.choices-container');

        function updateChoiceNames() {
            const card = optionsContainer.closest('.card');
            const itemIdx = Array.from(container.children).indexOf(card);
            choicesContainer.querySelectorAll('.choice-item').forEach((choiceDiv, cIndex) => {
                const labelInput = choiceDiv.querySelector('.choice-label');
                const valueInput = choiceDiv.querySelector('.choice-value');
                const hiddenId = choiceDiv.querySelector('input[type="hidden"]');

                labelInput.name = `items[${itemIdx}][choices][${cIndex}][label]`;
                valueInput.name = `items[${itemIdx}][choices][${cIndex}][value]`;
                if(hiddenId) hiddenId.name = `items[${itemIdx}][choices][${cIndex}][id]`;
            });
        }

        if(addBtn){
            addBtn.onclick = function () {
                const div = document.createElement('div');
                div.classList.add('choice-item', 'd-flex', 'gap-2', 'mb-2');
                div.innerHTML = `
                    <input type="text" name="" placeholder="Etiqueta" class="form-control choice-label">
                    <input type="text" name="" placeholder="Valor" class="form-control choice-value">
                    <button type="button" class="btn btn-danger btn-sm remove-choice">Eliminar</button>
                `;
                choicesContainer.appendChild(div);
                setupRemoveChoice();
                updateChoiceNames();
            };
        }

        setupRemoveChoice();
        updateChoiceNames();
    }

    function setupRemoveChoice() {
        document.querySelectorAll('.remove-choice').forEach(btn => {
            btn.onclick = function () {
                this.closest('.choice-item').remove();
                const containerDiv = this.closest('.card').querySelector('.choices-container');
                if(containerDiv) {
                    const optionsContainer = containerDiv.closest('.dynamic-options');
                    if(optionsContainer) setupChoices(optionsContainer);
                }
            };
        });
    }

    function updateIndexes() {
        document.querySelectorAll('#items-container .card').forEach((card, idx) => {
            card.querySelector('strong').innerText = `Pregunta ${idx + 1}`;
            const baseName = `items[${idx}]`;

            // actualizar order
            let orderInput = card.querySelector('input[name$="[item_order]"]');
            if(!orderInput){
                orderInput = document.createElement('input');
                orderInput.type = 'hidden';
                orderInput.name = `${baseName}[item_order]`;
                card.appendChild(orderInput);
            }
            orderInput.value = idx + 1;

            // actualizar nombres
            card.querySelectorAll('input, select').forEach((input) => {
                if(input.classList.contains('choice-label') || input.classList.contains('choice-value')) {
                    const choiceDiv = input.closest('.choice-item');
                    const choiceIdx = Array.from(choiceDiv.parentNode.children).indexOf(choiceDiv);
                    if(input.classList.contains('choice-label')) input.name = `${baseName}[choices][${choiceIdx}][label]`;
                    if(input.classList.contains('choice-value')) input.name = `${baseName}[choices][${choiceIdx}][value]`;

                    const hiddenId = choiceDiv.querySelector('input[type="hidden"]');
                    if(hiddenId) hiddenId.name = `${baseName}[choices][${choiceIdx}][id]`;
                }
                else if(input.classList.contains('response-type')) {
                    input.name = `${baseName}[response_type]`;
                }
                else if(input.type === "number" && input.name.includes("[meta]")) {
                    const isMin = input.placeholder === "Mínimo";
                    input.name = `${baseName}[meta][${isMin ? 'min' : 'max'}]`;
                }
                else if(!input.name.includes('[meta]') && input.type !== 'hidden' && !input.classList.contains('choice-label') && !input.classList.contains('choice-value') && !input.classList.contains('response-type')) {
                    input.name = `${baseName}[question_text]`;
                }
            });

            const itemId = card.dataset.itemId || '';
            if(itemId && !card.querySelector(`input[name="items[${idx}][id]"]`)) {
                const hiddenItemId = document.createElement('input');
                hiddenItemId.type = 'hidden';
                hiddenItemId.name = `items[${idx}][id]`;
                hiddenItemId.value = itemId;
                card.appendChild(hiddenItemId);
            }
        });
    }

    // Renderizar ítems existentes
    @if(isset($items) && count($items))
        const existingItems = @json($items);
        existingItems.forEach((item, idx) => createItem(idx, item));
    @endif

    addItemBtn.onclick = function () {
        const index = container.querySelectorAll('.card').length;
        createItem(index);
    };
});
</script>
