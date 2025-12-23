<template>
    <div class="error-msg">
        <div v-for="(validation, attribute) in this.validationObject.$params" :key="attribute">
            <span
                v-if="!validationObject[attribute] && validationObject.$error"
                class="invalid-feedback d-block"
                role="alert"
            >
                {{ getErrorMessage(validation) }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: ["validationObject", "fieldLabel"],

    methods: {
        getErrorMessage: function(validation) {
            switch (validation.type) {
                case "required":
                    return `The ${this.fieldLabel} field is required.`;

                case "minLength":
                    return `The ${this.fieldLabel} must be at least ${validation.params.min} characters.`;

                case "maxLength":
                    return `The ${this.fieldLabel} may not be greater than ${validation.params.max} characters.`;

                case "phone":
                    return `Invalid Phone Number format`;

                case "alphaNum":
                    return `Only use alphanumeric characters`;

                case "url":
                    return `Invalid URL`;

                case "requiredIf":
                    return `The ${this.fieldLabel} field is required.`;

                case "sameAs":
                case "sameAsPassword":
                    return `The ${this.fieldLabel} confirmation does not match.`;

                default:
                    return `Invalid ${this.fieldLabel}`;
            }
        }
    }
};
</script>


<style scoped>
.error-msg {
  line-height: 1;
  font-weight: normal;
}
</style>