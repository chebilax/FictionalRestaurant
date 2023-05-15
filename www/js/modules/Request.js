'use strict';

import Error from "./Error.js";

class Request {
    constructor()
    {
        //this.getInputs(inputs);
        this._firstName = "";
        this._lastName = "";
        this._birthDate = "";
        this._adress = "";
        this._city = "";
        this._postalCode = "";
        this._country = "";
        this._phone = "";
        this._mail = "";
        this._password = "";
        
    }

    getInputs(inputs) {
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].name == "firstName") {
                this.firstName = inputs[i].value;
            }
            if (inputs[i].name == 'lastName') {
                this.lastName = inputs[i].value;
            }
            if (inputs[i].name == 'birthDate') {
                this.birthDate = inputs[i].value;
            }
            if (inputs[i].name == 'mail') {
                this.mail = inputs[i].value;
            }
            if (inputs[i].name == 'password') {
                this.password = inputs[i].value;
            }
            if (inputs[i].name == 'adress') {
                this.adress = inputs[i].value;
            }
            if (inputs[i].name == 'city') {
                this.city = inputs[i].value;
            }
            if (inputs[i].name == 'postalCode') {
                this.postalCode = inputs[i].value;
            }
            if (inputs[i].name == 'country') {
                this.country = inputs[i].value;
            }
            if (inputs[i].name == 'phone') {
                this.phone = inputs[i].value;
            }
        }
    }

    get firstName() {
        return this._firstName;
    }

    set firstName(value) {
        if (value.length < 3) {
            let error = new Error("Le prénom doit comporter au moins 3 caractères", "firstName");
        } else if (!isNaN(value)) {
            let error = new Error("Le prénom ne doit pas comporter de nombres", "firstName");
        } else {
            this._firstName = value;
        }
    }

    get lastName() {
        return this._lastName;
    }

    set lastName(value) {
        if (value.length < 3) {
            let error = new  Error("Le nom doit comporter au moins 3 caractères", "lastName");
        } else if (!isNaN(value)) {
            let error = new Error("Le nom ne doit pas comporter de nombres", "lastName");
        } else {
            this._lastName = value;
        }
    }

    get birthDate() {
        return this._birthDate;
    }

    set birthDate(value) {
        const birthdate = new Date(value);
        const today = new Date();

        if (birthdate >= today) {
            let error =  new Error("La date de naissance ne doit pas être dans le futur", "birthDate");
        } else if (today.getFullYear() - birthdate.getFullYear() < 18) {
            let error =  new Error("Vous devez avoir au moins 18 ans pour vous inscrire", "birthDate");
        } else if (isNaN(birthdate)){
            let error = new Error("Vous devez saisir une date valide", "birthDate")
        } else {
            this._birthDate = birthdate;
        }
    }

    get mail() {
        return this._mail;
    }

    set mail(value) {
        const format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (!value.match(format)) {
            let error =  new Error("L'adresse mail renseigné est invalide", "mail");
        } else {
            this._mail = value;
        }
    }

    get password() {
      return this._password;
    }
    
    set password(newPassword) {
      if (newPassword.length < 8) {
        let error =  new Error("Le mot de passe doit comporter au moins 8 caractères","password");
        // span.showSpan();
      } else {
        this._password = newPassword;
      }
    }
    
    get adress() {
    return this._adress;
    }

    set adress(value) {
        if (value.length < 5) {
            let error = new Error("L'adresse doit comporter au moins 5 caractères", "adress");
        } else {
            this._adress = value;
        }
    }

    get city() {
        return this._city;
    }
    
    set city(value) {
        if (value.length < 3) {
            let error = new Error("Le nom de la ville doit comporter au moins 3 caractères", "city");
        } else {
            this._city = value;
        }
    }
    
    get postalCode() {
        return this._postalCode;
    }
    
    set postalCode(value) {
        const format = /^[0-9]{5}$/;
    
        if (!value.match(format)) {
            let error = new Error("Le code postal doit être un nombre à 5 chiffres", "postalCode");
        } else {
            this._postalCode = value;
        }
    }
    
    get country() {
        return this._country;
    }
    
    set country(value) {
        if (value.length < 3) {
            let error = new Error("Le nom du pays doit comporter au moins 3 caractères", "country");
        } else {
            this._country = value;
        }
    }
    
    get phone() {
        return this._phone;
    }
    
    set phone(value) {
        const format = /^(\+33|0)[1-9](\d{2}){4}$/;
    
        if (!value.match(format)) {
            let error = new Error("Le numéro de téléphone doit être un numéro de téléphone français valide (ex: 0606060606 ou +33606060606)", "phone");
        } else {
            this._phone = value;
        }
    }

}

export default Request;