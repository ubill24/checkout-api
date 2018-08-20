import React from 'react'
import Modal from 'react-native-modal';
import {View, WebView, Text, TouchableOpacity, Platform} from 'react-native';
import Icons from 'react-native-vector-icons/Ionicons';
import styles from '../style/styles';
const IS_IOS = Platform.OS === 'ios';

const WebViewModal = ({url, isVisible, closeModal,titleText,onMessage, onError,onNavigation}) =>

    <Modal
        isVisible={isVisible}
        avoidKeyboard={false}
        style={styles.modalStyles}
        backdropOpacity={0.1}
        backdropColor='#FFFFFF'
        animationOutTiming={1}
        animationInTiming={1}
        animationOut='zoomInDown'
    >
        <View style={styles.wrapperContainer}>
                    <View style={styles.addItemContainer}>
                            <View>
                                <TouchableOpacity
                                    onPress={closeModal}
                                    style = {styles.headerLeft}
                                >
                                    <Icons
                                        name = 'md-arrow-back'
                                        backgroundColor = 'transparent'
                                        color = '#fff'
                                        size = {28}
                                    />
                                </TouchableOpacity>
                            </View>
                            <View>
                                <Text style={styles.dropdownHeaderCenter}>Check Out</Text>
                            </View>
                            <View style={{paddingLeft:15}}/>
                        </View>
            <WebView
                style={styles.wrapperContainer}
                source={{uri: url}}
                javaScriptEnabled={true}
                domStorageEnabled={true}
                startInLoadingState={true}
                onMessage={onMessage}
                onError={onError}
                allowsInlineMediaPlayback={true}
                geolocationEnabled={true}
                allowUniversalAccessFromFileURLs={true}
                onNavigationStateChange={onNavigation}
            />
        </View>
    </Modal>
export default WebViewModal;
