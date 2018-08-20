import React from 'react';
import { View, Text, ListView, TouchableOpacity, Image } from 'react-native';
import styles from '../style/styles'
import _ from 'lodash'
const ViewAttactment = ({ dataSource, handleOpenImage, add }) =>
    <View
        style={styles.listImageAttachment}
    >
            {
                _.map(dataSource,(u,j) => {
                    return (
                        <View key={j}>
                            <Image
                                style={styles.imageView}
                                source={{uri: u}}
                            />
                        </View>
                      )
                })
            }
    </View>
export default ViewAttactment;
