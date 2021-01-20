public class DocURL extends DocBibliotheque {

    private String url;
    private String desc;

    DocURL(String code, String auteur, String url, String desc){
        super(code, auteur);
        this.url = url;
        this.desc = desc;
    }

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    public String getDesc() {
        return desc;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    public String toString(){
        return(super.toString() + url + desc);
    }
}
