import { StyleSheet, Platform , Dimensions} from 'react-native';
const IS_IOS = Platform.OS === 'ios';
const { width: viewportWidth, height: viewportHeight } = Dimensions.get('window');
export default styles = StyleSheet.create({
    addItemContainer: {
        paddingTop: IS_IOS && viewportHeight === 812 || viewportWidth === 812 ? 32 : IS_IOS ? 15 : 0,
        justifyContent: 'space-between',
        alignItems: 'center',
        flexDirection: 'row',
        backgroundColor: '#03A9F4',
        height: IS_IOS && viewportHeight === 812 || viewportWidth === 812 ? 85 : IS_IOS ? 64 : 45,
    },
    container: {
        flex: 1,
        backgroundColor: '#ffffff',
        margin: 0,
        padding: 0,
        width: '100%',
        height: '100%',
    },
    dropdownHeaderCenter: {
        color: "#fff", fontWeight: 'bold',
        fontSize: 16, paddingRight: 20
    },
    listSingleInputDropdown: {
        backgroundColor: 'transparent',
        justifyContent: 'space-between',
        flexDirection: 'row',
        paddingLeft: 20,
        paddingRight: 20,
        alignItems: 'center',
        flex: 1,
        height: 42
    },
    inlineText: {
        flex: 3,
        marginTop: 0,
        marginBottom: 0,
        padding: 0,
        justifyContent: 'center',
        alignItems: 'flex-start',
        height: 42,
        backgroundColor: 'transparent',
    },
    inlineTexts: {
        flex: 3,
        marginTop: 0,
        marginBottom: 0,
        padding: 0,
        justifyContent: 'center',
        alignItems: 'flex-start',
        height: 52,
        backgroundColor: 'transparent',
    },
    inputTextStyle: {
        height: 42,
        paddingLeft: 10,
        width: '100%',
        backgroundColor: 'transparent',
        borderWidth: 1,
        borderColor: '#757575',
        borderRadius: 10,
        paddingRight: 10
    },
    inlineLabelInput: {
        flex: 2,
        alignItems: 'center',
        justifyContent: 'center',
        margin: 0,
        padding: 0,
    },
    labelTextInput: {
        alignSelf: 'flex-start',
        textAlign: 'center',
        margin: 0,
        padding: 0,

    },
    listSingleInput: {
        backgroundColor: 'transparent',
        justifyContent: 'space-between',
        flexDirection: 'row',
        paddingLeft: 20,
        paddingRight: 20,
        alignItems: 'center',
        flex: 1,
        height: 42,
        maxHeight: 62,
        minHeight: 48,

    },
    listSingleItem: {
        justifyContent: 'center',
        alignItems: 'center',
        flexDirection: 'row',
        flex: 1,
        height: 42,
        maxHeight: 52,
        minHeight: 48,
        width: '100%',
    },
    listSingleItems: {
        backgroundColor: 'transparent',
        justifyContent: 'space-between',
        flexDirection: 'row',
        paddingLeft: 20,
        paddingRight: 20,
        alignItems: 'center',
        flex: 1,
        height: 52,
        maxHeight: 62,
        minHeight: 48,
    },
    deviderLineMarginLeft20Right20: {
        marginRight: 20,
        marginLeft: 20,
        borderBottomColor: '#424242',
        borderBottomWidth: 1, width: '90%',
        justifyContent: 'center',
        alignItems: 'center'
    },
    headingTitle: {
        textAlign: 'center',
        fontSize: 30,
        padding: 15,
        color: '#fff'
    },
    subTitle: {
        justifyContent: 'space-between',
        alignItems: 'center',
        flexDirection: 'row',
        paddingLeft: 20,
        paddingRight: 20
    },
    subTitle1: {
        justifyContent: 'space-between',
        alignItems: 'center',
        flexDirection: 'row',
        paddingLeft: 30,
        paddingRight: 30
    },
    textLeft: {
        flexDirection: 'column',
        alignItems: 'center'
    },
    subTextTitle: {
        fontSize: 18,
        padding: 10,
        color: '#fff'
    },
    modalStyles: {
        justifyContent: 'center',
        flex: 1, margin: 0,
        padding: 0, width: '100%',
        height: '100%',
        alignItems: 'center'
    },
    wrapperContainer: {
        flex: 1,
        width: '100%',
        height: '100%',
        margin: 0,
        padding: 0
    },
    headerLeft: {
        paddingLeft: 15,
        paddingRight: 10,
        paddingTop: 5,
        paddingBottom: 5
    },
    noAttachmentWrapper:{
        alignItems:'center',
        justifyContent:'center',
        borderColor:'#f2f2f2',
        width:'100%',
        flex:1,
        backgroundColor:'#FAFAFA',
        borderRadius: 3,
        marginBottom: 2
    },
    listImageAttachment:{
     backgroundColor: 'transparent',
     justifyContent: 'space-between',
     flexDirection:'row',
     marginLeft: 0,
     marginRight:0,
     paddingLeft: 0,
     paddingRight: 0,
     paddingTop: 0,
     paddingBottom:0,
     flex:1,
     marginTop: 5,
 },
 imageView: {
       width:100,
       height:130,
       borderWidth:0.5,
       borderColor:'white',
   },
    labelTextInput:{
        alignSelf:'flex-start',
        textAlign:'center',
        margin:0,
        padding:0,
    },
});
