  1. ummary One-sentence summary of this page.

# Flow on Demand #
Phát triển dựa trên [CuteFlow](http://www.cuteflow.org). [CuteFlow's features](http://www.cuteflow.org/features.html) đã thỏa gần hết các yêu cầu của một webbased workflow cơ bản
  * Lập qui trình (document template)
  * Tùy biến field cho mỗi template
  * Lập danh sách maillist

Việc phát triển thêm chức năng cho CuteFlow sẽ gồm những công việc sau đây

# Các chức năng bắt buộc customize #
  1. Chuyển các cửa sổ popup thành div cho đẹp hơn và bước đầu làm quen với code của Cute.
  1. Có thể sử dụng db MS SQL Server 2000/2005.
  1. Thêm các field phù hợp với yêu cầu của dự án, ví dụ: field lookup từ một table cho trước
    * Người duyệt chi sẽ quyết định gắn request này vào Budget nào, nên cần có field lookup budget ở đây.
  1. Gắn DateChooser javascript cho Date field.
  1. Ghi chú về Role và Phân quyền: hiện tại chỉ có 4 quyền => không đủ chi tiết. Số quyền chưa tương xứng với số đối tượng: Documemnt template, Mailling List, User, System setting.
    * Role Read only: được xem Circulations, Circulation Archives, Todo nhưng không được edit gì.
    * Role Reciver: được edit field trong slot của mình với một document đang chạy.
    * Role Sender: được quá nhiều quyền, kể cả skip station của một circulation đang chạy mà không thuộc quyền của mình. Chức năng này nên được bổ sung như sau: cho biết người skip station này là ai và khi skip bắt buộc phải comment lý do. Chức năng skip phù hợp khi người chịu trách nhiệm ở slot đi vắng hoặc nghỉ đẻ chẳng hạn.
  1. Cần bổ sung thêm Role:
    * Quản lý Document template.
    * Quản lý Mailling list.
    * Skip group
    * Hầu như ai cũng có quyền tạo Request - Circulation nên không cần phải chia ra sender, reciver và readonly.
  1. Viết thêm plugin để trình bày Budget info/status.
  1. Cần thêm chức năng duplicate Document template, Mailling list, Field để tiện cho người dùng

# Các chức năng có độ ưu tiên thấp #
  1. Layout slot field bằng cách kéo thả, hiệnn tại layout của slotfield rất cứng nhắc.
  1. Việt hóa.