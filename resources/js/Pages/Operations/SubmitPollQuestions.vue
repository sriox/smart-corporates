<template>
    <SubmitLayout :company="company" :poll="poll" class="text-xl">
        <div class="explanation border border-gray-300 rounded p-2 bg-blue-100 text-blue-800 mb-3">
            <span class="font-bold md:text-2xl">Por favor conteste las preguntas que aparecen a continuación, teniendo en cuenta la siguiente escala:</span>
            <ul>
                <li v-for="answer in answers" :key="answer.id" class="text-base lg:text-xl">{{ answer.value }} - {{ answer.name }}</li>
            </ul>
        </div>
        <div class="questions">
            <PollQuestion class="" v-for="(question, index) in questions.data" :key="question.id" :status="isReady(question.id) ? 'success' : ''">
                <div class="grid grid-cols-5">
                    <div class="text-gray-900 col-span-5 md:col-span-4">{{ index + 1 + (page - 1) * questions.per_page }}. {{ question.question }}</div>
                    <div class="answers col-span-5 md:col-span-1">
                        <RadioButtonGroup
                            :options="answers"
                            direction="horizontal"
                            text-field="value"
                            :name="`answers-${question.id}`"
                            @update:checked="(val) => setAnswer(question.id, val)"
                            :model-value="getQuestionAnswer(question.id)"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollQuestion>
        </div>
        <div class="info">{{ Math.round(((questions.current_page + 1) / (questions.last_page + 2)) * 100) }}%</div>
        <div class="submit-button py-3">
            <Button block :disabled="!answersReady" @click="submit">Continuar ({{ pollAnswers.length }} / {{ questions.data.length }})</Button>
        </div>
    </SubmitLayout>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia'
import { computed, onMounted, reactive, ref, toRefs, watch } from 'vue'
import Button from '../../Components/Button.vue'

const props = defineProps({
    participant: {
        type: Object,
        required: true,
    },
    code: {
        type: String,
        required: true,
    },
    questions: {
        type: Object,
    },
    answers: {
        type: Array,
        default: () => [],
    },
    company: {
        type: Object,
        required: true,
    },
    poll: {
        type: Object,
        required: true,
    },
    page: {
        type: [Number, String],
        default: 1,
    },
})

const { participant, code, questions, answers, company, poll, page } = toRefs(props)

const pollAnswers = ref([])

const lastPage = computed(() => questions.value.current_page === questions.value.last_page)

const setAnswer = (questionId, answerId) => {
    const pa = pollAnswers.value.filter((item) => item.questionId !== questionId)
    pa.push({ questionId, answerId })
    pollAnswers.value = pa
}

const isReady = (questionId) => !!pollAnswers.value.find((item) => item.questionId === questionId)
const answersReady = computed(() => questions.value.data.length === pollAnswers.value.length)

const submit = () => {
    if (!answersReady) return
    Inertia.post(route('answers.submit', { code: code.value, page: page.value, lastPage: lastPage.value }), { pollAnswers: pollAnswers.value })
    pollAnswers.value = []
}

const getQuestionAnswer = (questionId) => {
    const answer = participant.value.participant_poll_answers.find((item) => item.question_id === questionId)
    return !answer ? '' : `${answer.poll_answer_id}`
}

const setAnswers = () => {
    const answers = participant.value.participant_poll_answers
        .filter((item) => questions.value.data.map((item) => item.id).includes(item.question_id))
        .map((item) => ({ questionId: item.question_id, answerId: item.poll_answer_id }))
    pollAnswers.value = answers
}

watch(questions, (val) => {
    setAnswers()
})

onMounted(() => {
    setAnswers()
})
</script>
