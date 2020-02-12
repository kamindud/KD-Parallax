// append Element

class singleElement {

    appendedImages = 0;
    calledFrom = false;
    selectedImages = [];
    mainTitles = [];
    subTitles = [];
    mainColors = [];
    subColors = [];
    singleImagesInput = document.querySelector('#single-images');
    mainTitilesInput = document.querySelector('#main-titles');
    subTitlesInput = document.querySelector('#sub-titles');
    mainColorsInput = document.querySelector('#main-title-colors');
    subColorsInput = document.querySelector('#sub-title-colors');
    movingSpeedInput = document.querySelector('#moving-speed');
    elementSaveError = false;

    constructor() {
        if (this.singleImagesInput.value !== "") {
            let existingElements = this.singleImagesInput.value.split(',');
            if (existingElements.length > 0) {
                this.appendedImages = existingElements.length;
            };
        }

    }

    // append Empty Element
    appendElement(parentElement, focusedElement) {
        let basicContent = `
        <div class="preview-img" id="single-${this.appendedImages + 1}">
            <a class="close-single" data-id="${this.appendedImages + 1}" onclick="close_single_element(event)">X</a>
            <a href="#" onclick="open_media(${this.appendedImages + 1})" id="open-media"><img src="${emptyImage}" id="preview-thumb-${this.appendedImages + 1}" alt="" srcset=""></a>
            <input class="kd-single-input" type="text" id="single-main-title-${this.appendedImages + 1}" placeholder="Main Title">
            <input class="kd-single-input" type="text" id="single-sub-title-${this.appendedImages + 1}" placeholder="Sub Title">
            <input class="kd-single-input" type="text" id="single-Main-color-${this.appendedImages + 1}" placeholder="Main Title Color">
            <input class="kd-single-input" type="text" id="single-sub-color-${this.appendedImages + 1}" placeholder="Sub Title Color">
            <input class="kd-single-input" type="text" id="single-moving-speed-${this.appendedImages + 1}" placeholder="Moving Speed">
            <input type="button" class="kd-single-btn submit-single" onclick="submitSingle(${this.appendedImages + 1})" value="Save">
        </div>`;
        let newDiv = document.createElement('div');
        newDiv.classList.add('single-gal-element');
        newDiv.innerHTML = basicContent;
        parentElement.insertBefore(newDiv, focusedElement);
        this.appendedImages++;
    }

    // close Element
    removeElement(mainEl, calledId) {
        let existingContent = new Array();
        existingContent['singleImages'] = this.singleImagesInput;
        existingContent['mainTitilesInput'] = this.mainTitilesInput;
        existingContent['subTitlesInput'] = this.subTitlesInput;
        existingContent['mainColorsInput'] = this.mainColorsInput;
        existingContent['subColorsInput'] = this.subColorsInput;
        existingContent['movingSpeedInput'] = this.movingSpeedInput;
        let index = calledId - 1;

        // console.log(Object.keys(existingContent));


        Object.keys(existingContent).forEach(element => {
            let newElement = existingContent[element].value.split(',');
            newElement.splice(index, 1);
            existingContent[element].value = newElement.join(',');
        });

        // console.log(existingContent);
        mainEl.parentElement.remove();

    }

    // open media popup

    openMediaPopup(elId) {
        this.calledFrom = elId;

        let fileFrame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false	// Set to true to allow multiple files to be selected
        });

        fileFrame.open();

        fileFrame.on('select', function () {
            let attachment = fileFrame.state().get('selection').first().toJSON();
            document.getElementById(`preview-thumb-${elId}`).src = attachment.url;
        });

    }

    // save single element
    saveSingleElement(elementId) {

        console.log(elementId);
        this.calledFrom = elementId;
        let elementImage = document.getElementById(`preview-thumb-${elementId}`);
        let mainTitle = document.getElementById(`single-main-title-${elementId}`);
        let subTitle = document.getElementById(`single-sub-title-${elementId}`);
        let mainColor = document.getElementById(`single-Main-color-${elementId}`);
        let subColor = document.getElementById(`single-sub-color-${elementId}`);
        let movingSpeed = document.getElementById(`single-moving-speed-${elementId}`);

        console.log(movingSpeed);

        // verify image
        if (elementImage.src === undefined) {
            this.elementSaveError = true;
        }
        // verify main title
        if (mainTitle.value === '') {
            this.elementSaveError = true;
        }

        if (!this.elementSaveError) {
            let selectedImages = [];
            let mainTitles = [];
            let subTitles = [];
            let mainColors = [];
            let subColors = [];
            let movingSpeeds = [];

            // get images
            if (this.singleImagesInput.value.length > 0) {
                selectedImages = this.singleImagesInput.value.split(',');
            }
            // get main title
            if (this.mainTitilesInput.value.length > 0) {
                mainTitles = this.mainTitilesInput.value.split(',');
            }
            // get subTitle
            if (this.subTitlesInput.value.length > 0) {
                subTitles = this.subTitlesInput.value.split(',');
            }
            // get main color
            if (this.mainTitilesInput.value.length > 0) {
                mainColors = this.mainColorsInput.value.split(',');
            }
            // get sub color
            if (this.mainTitilesInput.value.length > 0) {
                subColors = this.subColorsInput.value.split(',');
            }
            // get moving speed
            if (this.movingSpeedInput.value.length > 0) {
                movingSpeeds = this.subColorsInput.value.split(',');
            }


            if (selectedImages.length > elementId) {
                // push current values to arrays
                selectedImages.push(elementImage.src);
                mainTitles.push(mainTitle.value);
                subTitles.push(subTitle.value);
                mainColors.push(mainColor.value);
                subColors.push(subColor.value);
                movingSpeeds.push(movingSpeed.value);

                console.log(selectedImages);
                // console.log(selectedImages , mainTitles , subTitles , mainColors , subColors);
            } else {
                // push current values to arrays
                selectedImages[elementId - 1] = elementImage.src;
                mainTitles[elementId - 1] = mainTitle.value;
                subTitles[elementId - 1] = subTitle.value;
                mainColors[elementId - 1] = mainColor.value;
                subColors[elementId - 1] = subColor.value;
                movingSpeeds[elementId - 1] = movingSpeed.value;

                // console.log(selectedImages , mainTitles , subTitles , mainColors , subColors);

            }

            console.log(selectedImages);
            // reassign content to hidden input fields
            this.singleImagesInput.value = selectedImages.join(',');
            this.mainTitilesInput.value = mainTitles.join(',');
            this.subTitlesInput.value = subTitles.join(',');
            this.mainColorsInput.value = mainColors.join(',');
            this.subColorsInput.value = subColors.join(',');
            this.movingSpeedInput.value = movingSpeeds.join(',');

        } else {

        }
    }

}

// initiate element class
let handleElenemts = new singleElement();

// append elements
const appendImg = (e) => {
    let mainElement = document.querySelector('.kd-main-div-wrapper');
    let currentElement = e.target.parentElement.parentElement.parentElement;
    handleElenemts.appendElement(mainElement, currentElement);
}

// close element
let close_single_element = (e) => {
    let mainEl = document.getElementById(`single-${e.target.dataset.id}`);
    handleElenemts.removeElement(mainEl, e.target.dataset.id);

}

let open_media = (elId) => {
    handleElenemts.openMediaPopup(elId);
}

let submitSingle = (element) => {
    handleElenemts.saveSingleElement(element);
}