function validateForm() {
    const innerDiv = document
        .querySelector('#Product')
        .getElementsByClassName('free')
    if (innerDiv.length = 0) {
        alert("Error: Please add product details");
        return false;
    }
}



