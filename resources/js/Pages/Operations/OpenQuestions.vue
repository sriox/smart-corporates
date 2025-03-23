<template>
    <SubmitLayout :poll="poll" :company="company">
        <div class="questions">
            <PollQuestion v-for="(question, index) in openQuestions" :key="question.id">
                <Input
                    @input="(e) => setAnswer(question, e.target.value)"
                    :label="`${index + 1 + pollQuestionsCount}. ${question.question}`"
                    :help="question.description"
                    :type="question.type"
                ></Input>
            </PollQuestion>
        </div>
        <div class="submit-button py-3">
            <Button block @click="submit">Finalizar</Button>
        </div>
    </SubmitLayout>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia'
import { computed, ref, toRefs } from 'vue'

const props = defineProps({
    code: {
        type: String,
        required: true,
    },
    openQuestions: {
        type: Array,
        default: () => [],
    },
    poll: {
        type: Object,
        required: true,
    },
    company: {
        type: Object,
        required: true,
    },
    pollQuestionsCount: {
        type: Number,
        default: 0,
    },
})

const { poll, company, pollQuestionsCount, openQuestions, code } = toRefs(props)

const answers = ref([])

const setAnswer = (question, answer) => {
    const _answers = answers.value.filter((item) => item.questionId !== question.id)
    _answers.push({
        questionId: question.id,
        questionType: question.type,
        answer,
    })
    answers.value = _answers
}

const formReady = computed(() => {
    return answers.value.length === openQuestions.value.length
})

const submit = () => {
    // if (!formReady.value) return
    Inertia.post(route('openQuestions.store', { code: code.value }), { answers: answers.value })
}
</script>
