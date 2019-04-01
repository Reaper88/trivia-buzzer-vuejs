/* 
 * The MIT License
 *
 * Copyright 2017 Reaper.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
import * as types from '../mutation_types'
import Axios from 'axios'
import Vue from 'vue'

Vue.use(Axios)

export default {
    state: {},
    getters: {
        generalSettings: (state) => {
            return state;
        }
    },
    actions: {
        grabConfig: ({state, commit, rootState}) => {
            Axios.get('/', {
                    headers: {
                        Authorization: rootState.token
                    }
                })
            .then((response) => {
                commit(types.SET_CONFIG, {list: response.data})
            })
        },
        setSettings: ({state, commit, rootState}, list) => {
            Axios.post('/', list, {
                    headers: {
                        Authorization: rootState.token
                    }
                }).then((response) => {
                    commit(types.SET_CONFIG, {list: list})
                })
        }
    },
    mutations: {
        SET_CONFIG: (state, {list}) => {      
            state = list;
        }
    }
}
