import React from 'react'
import {View, Text, } from 'react-native'
import styles from '../style/styles'

const LabelInput = ({text}) =>
    <View style={[styles.inlineLabelInput]}>
        <Text style={[styles.labelTextInput,]}>
            {text || ''}
        </Text>
    </View>;

export default LabelInput;