import { computed, isRef } from 'vue';

export const useMonthlyPayment = (total, interestRate, duration) => {
    const monthlyPayment = computed(() => {
        // the total amount borrowed
        const principal = isRef(total) ? total.value : total
        // Annual interest rates are usually given as percentages (like 5%). To use it in the math, you first divide by 100 to make it a decimal (0.05), and then divide by 12 to get the interest rate per month.
        const monthlyInterest = (isRef(interestRate) ? interestRate.value : interestRate) / 100 / 12
        // Loan terms are usually given in years. Multiplying by 12 gives you the total number of monthly payments you will make.
        const numberOfPaymentMonths = (isRef(duration) ? duration.value : duration) * 12
    
        // the formula is written as M = P * (r * (1 + r)^n) / ((1 + r)^n - 1)
        // M is the Monthly Payment -> monthlyPayment
        // P is the Principal amount (the total amount borrowed) -> principal
        // r is the monthly interest rate -> monthlyInterest
        // n is the total number of monthly -> numberOfPaymentMonths
        // Math.pow(base, exponent)
        return principal * (monthlyInterest * Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
    })

    const totalPaid = computed(() => {
        return (isRef(duration) ? duration.value : duration) * 12 * monthlyPayment.value
    })

    const totalInterest = computed(() => totalPaid.value - (isRef(total) ? total.value : total) )
    
    return { 
        monthlyPayment, 
        totalPaid,
        totalInterest,
    }
}